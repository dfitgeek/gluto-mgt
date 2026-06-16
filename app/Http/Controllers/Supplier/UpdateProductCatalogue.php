<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Models\SupplierProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UpdateProductCatalogue extends Controller
{
    /**
     * Parse and update existing product catalogue configurations securely.
     */
    public function update(Request $request, $id)
    {
        if (!Auth::guard('supplier')->check()) {
            return abort(403, 'Unauthorized operation attempt.');
        }

        $supplierId = Auth::guard('supplier')->user()->id;

        // Lock queries to the logged-in supplier profile
        $product = SupplierProduct::where('id', $id)
            ->where('supplier_profile_id', $supplierId)
            ->firstOrFail();

        $method = $request->input('submission_method', 'manual');

        if ($method === 'upload') {
            $validated = $request->validate([
                'bulk_product_name' => 'required|string|max:255',
                'bulk_product_category' => 'required|string|max:100',
                'product_catalogue' => 'nullable|file|mimes:pdf,xls,xlsx|max:10240',
            ]);

            // CASE 1: Supplier is swapping strategies from manual inputs to a bulk catalog file.
            // Clean up any historical manual images stored on disk.
            if (is_array($product->product_images)) {
                foreach ($product->product_images as $oldImg) {
                    Storage::disk('public')->delete($oldImg);
                }
            }

            // Handle incoming document substitution
            $cataloguePath = $product->product_catalogue;
            if ($request->hasFile('product_catalogue') && $request->file('product_catalogue')->isValid()) {
                if ($product->product_catalogue) {
                    Storage::disk('public')->delete($product->product_catalogue);
                }
                $cataloguePath = $request->file('product_catalogue')->store('supplier_catalogs/docs', 'public');
            }

            $product->update([
                'product_name' => $validated['bulk_product_name'],
                'product_category' => $validated['bulk_product_category'],
                'product_catalogue' => $cataloguePath,
                'product_images' => null, // Clear out image array arrays
                'price_pieces' => 0.0000,
                'pcs_per_case' => 0,
                'cases_per_pallet' => 0,
                'pcs_per_pallet' => 0,
                'overall_moqs' => 'Refer to document sheet file references.',
                'production_capacity' => null,
                'pricing_structure_type' => 'Bulk File Data Sheet',
                'full_truckload_details' => null,
                'payment_terms' => null,
                'ability_to_provide_samples' => false,
                'shelf_life' => null,
                'ean_upc_code' => null,
                'product_description' => 'Bulk documentation catalog portfolio sheet replaced directly by vendor representative.',
            ]);

        } else {
            // CASE 2: Process manual data parameters updates
            $validated = $request->validate([
                'product_name' => 'required|string|max:255',
                'product_category' => 'required|string|max:100',
                'price_pieces' => 'required|numeric|min:0',
                'product_images' => 'nullable|array|max:4',
                'product_images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
                'ean_upc_code' => 'nullable|string|max:50',
                'shelf_life' => 'nullable|string|max:100',
                'product_description' => 'nullable|string',
                'pcs_per_case' => 'nullable|integer|min:0',
                'cases_per_pallet' => 'nullable|integer|min:0',
                'pcs_per_pallet' => 'nullable|integer|min:0',
                'overall_moqs' => 'nullable|string|max:255',
                'production_capacity' => 'nullable|string|max:255',
                'pricing_structure_type' => 'nullable|string|max:100',
                'full_truckload_details' => 'nullable|string|max:255',
                'payment_terms' => 'nullable|string',
            ]);

            // If switching from bulk upload mode to manual fields context, delete the old PDF
            if ($product->product_catalogue) {
                Storage::disk('public')->delete($product->product_catalogue);
                $product->product_catalogue = null;
            }

            // Image collection array update logic execution
            $imagePathsCollection = $product->product_images; // Preserve the current array values as default
            if ($request->hasFile('product_images')) {
                // Delete previous file assets from storage completely
                if (is_array($product->product_images)) {
                    foreach ($product->product_images as $oldImg) {
                        Storage::disk('public')->delete($oldImg);
                    }
                }

                // Hydrate fresh directory locations array list strings
                $imagePathsCollection = [];
                foreach ($request->file('product_images') as $freshImage) {
                    if ($freshImage->isValid()) {
                        $imagePathsCollection[] = $freshImage->store('supplier_products/images', 'public');
                    }
                }
            }

            $product->update([
                'product_name' => $validated['product_name'],
                'product_category' => $validated['product_category'],
                'price_pieces' => $validated['price_pieces'],
                'product_images' => $imagePathsCollection,
                'ean_upc_code' => $validated['ean_upc_code'],
                'shelf_life' => $validated['shelf_life'],
                'product_description' => $validated['product_description'],
                'pcs_per_case' => $validated['pcs_per_case'] ?? 0,
                'cases_per_pallet' => $validated['cases_per_pallet'] ?? 0,
                'pcs_per_pallet' => $validated['pcs_per_pallet'] ?? 0,
                'overall_moqs' => $validated['overall_moqs'],
                'production_capacity' => $validated['production_capacity'],
                'pricing_structure_type' => $validated['pricing_structure_type'],
                'full_truckload_details' => $validated['full_truckload_details'],
                'payment_terms' => $validated['payment_terms'],
                'ability_to_provide_samples' => $request->has('ability_to_provide_samples'),
                'product_catalogue' => null,
            ]);
        }

        return redirect()->route('supplier.products')
            ->with('success', "Catalogue parameters for '{$product->product_name}' were saved successfully.");
    }
}
