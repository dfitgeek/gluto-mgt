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

        // Lock queries strictly to the logged-in supplier profile
        $product = SupplierProduct::where('id', $id)
            ->where('supplier_profile_id', $supplierId)
            ->firstOrFail();

        $method = $request->input('submission_method', 'manual');

        if ($method === 'upload') {
            // Enforce strict file requirements context rules based on current DB state
            $catalogRule = $product->product_catalogue ? 'nullable|file|mimes:pdf,xls,xlsx|max:10240' : 'required|file|mimes:pdf,xls,xlsx|max:10240';

            $validated = $request->validate([
                'bulk_product_name' => 'required|string|max:255',
                'bulk_product_category' => 'required|string|max:100',
                'product_origin' => 'required|string',
                'product_catalogue' => $catalogRule,
                'bulk_price_pieces' => 'required|numeric|min:0',
                'bulk_ean_upc_code' => 'nullable|string|max:50',
                'bulk_shelf_life' => 'nullable|string|max:100',
                'bulk_pcs_per_case' => 'nullable|integer|min:0',
                'bulk_cases_per_pallet' => 'nullable|integer|min:0',
                'bulk_pcs_per_pallet' => 'nullable|integer|min:0',
                'bulk_overall_moqs' => 'nullable|string|max:255',
                'bulk_production_capacity' => 'nullable|string|max:255',
            ], [
                'product_catalogue.required' => 'You must upload a valid PDF or Excel spreadsheet catalog template to save bulk modifications.',
            ]);

            // Clean up manual input image gallery assets on disk when prioritizing bulk file modes
            if (is_array($product->product_images)) {
                foreach ($product->product_images as $oldImg) {
                    Storage::disk('public')->delete($oldImg);
                }
            }

            // Handle structural document replacement swap loops safely
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
                'product_origin' => $validated['product_origin'],
                'price_pieces' => $validated['bulk_price_pieces'],
                'product_catalogue' => $cataloguePath,
                'product_images' => null,
                'ean_upc_code' => $validated['bulk_ean_upc_code'] ?? null,
                'shelf_life' => $validated['bulk_shelf_life'] ?? null,
                'pcs_per_case' => $validated['bulk_pcs_per_case'] ?? 0,
                'cases_per_pallet' => $validated['bulk_cases_per_pallet'] ?? 0,
                'pcs_per_pallet' => $validated['bulk_pcs_per_pallet'] ?? 0,
                'overall_moqs' => $validated['bulk_overall_moqs'] ?? 'Refer to document sheet file references.',
                'production_capacity' => $validated['bulk_production_capacity'] ?? null,
                'ability_to_provide_samples' => $request->has('bulk_ability_to_provide_samples'),
                'pricing_structure_type' => 'Bulk File Data Sheet',
                'full_truckload_details' => null,
                'payment_terms' => null,
                'product_description' => 'Bulk documentation catalog portfolio sheet replaced directly by vendor representative.',
            ]);

        } else {
            $validated = $request->validate([
                'product_name' => 'required|string|max:255',
                'product_category' => 'required|string|max:100',
                'product_origin' => 'required|string',
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

            if ($product->product_catalogue) {
                Storage::disk('public')->delete($product->product_catalogue);
                $product->product_catalogue = null;
            }

            $imagePathsCollection = $product->product_images;
            if ($request->hasFile('product_images')) {
                if (is_array($product->product_images)) {
                    foreach ($product->product_images as $oldImg) {
                        Storage::disk('public')->delete($oldImg);
                    }
                }

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
                'product_origin' => $validated['product_origin'],
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
