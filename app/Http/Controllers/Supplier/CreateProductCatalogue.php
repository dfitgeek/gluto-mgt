<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Models\SupplierProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class CreateProductCatalogue extends Controller
{
    /**
     * Intercept, cross-validate, and map the product catalogue record row.
     */
    public function store(Request $request)
    {
        // 1. Enforce strict defensive guard safety validation check limits
        if (!Auth::guard('supplier')->check()) {
            return abort(403, 'Unauthenticated operations sequence context token blocked.');
        }

        $supplier = Auth::guard('supplier')->user();
        $method = $request->input('submission_method', 'manual');

        // 2. Compile conditional validation rulesets depending on active layout tab source
        if ($method === 'upload') {
            $validated = $request->validate([
                'bulk_product_name' => 'required|string|max:255',
                'bulk_product_category' => 'required|string|max:100',
                'product_catalogue' => 'required|file|mimes:pdf,xls,xlsx|max:10240', // Max 10MB bulk files sheet
            ]);

            // Map variables into normalized standard array slots
            $productName = $validated['bulk_product_name'];
            $productCategory = $validated['bulk_product_category'];
            $cataloguePath = $request->file('product_catalogue')->store('supplier_catalogs/docs', 'public');
            $imagePathsCollection = null; // Set null for single file method strategies

            // Clean baseline initial defaults for structural metrics columns
            $pricePieces = 0.0000;
            $pcsPerCase = 0;
            $casesPerPallet = 0;
            $pcsPerPallet = 0;
            $moqs = 'Refer to document template sheet specifications logs';
            $capacity = null;
            $pricingType = 'Bulk Catalog Sheet';
            $ftlDetails = null;
            $terms = null;
            $samples = false;
            $life = null;
            $ean = null;
            $desc = 'Bulk documentation catalog portfolio sheet file uploaded directly by vendor.';

        } else {
            // Processing extensive fully custom manual fields configuration matrix validations rulesets
            $validated = $request->validate([
                'product_name' => 'required|string|max:255',
                'product_category' => 'required|string|max:100',
                'price_pieces' => 'required|numeric|min:0',
                'product_images' => 'required|array|min:1|max:4',
                'product_images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048', // Max 2MB per snapshot photo container
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

            $productName = $validated['product_name'];
            $productCategory = $validated['product_category'];
            $cataloguePath = null;
            $pricePieces = $validated['price_pieces'];
            $pcsPerCase = $validated['pcs_per_case'] ?? 0;
            $casesPerPallet = $validated['cases_per_pallet'] ?? 0;
            $pcsPerPallet = $validated['pcs_per_pallet'] ?? 0;
            $moqs = $validated['overall_moqs'];
            $capacity = $validated['production_capacity'];
            $pricingType = $validated['pricing_structure_type'];
            $ftlDetails = $validated['full_truckload_details'];
            $terms = $validated['payment_terms'];
            $samples = $request->has('ability_to_provide_samples');
            $life = $validated['shelf_life'];
            $ean = $validated['ean_upc_code'];
            $desc = $validated['product_description'];

            // Loop and bundle image upload strings directly into a clean PHP tracking array
            $imagePathsCollection = [];
            if ($request->hasFile('product_images')) {
                foreach ($request->file('product_images') as $imageAsset) {
                    if ($imageAsset->isValid()) {
                        $imagePathsCollection[] = $imageAsset->store('supplier_products/images', 'public');
                    }
                }
            }
        }

        // 3. Persist core catalogue rows mapping straight into your supplier_products table
        SupplierProduct::create([
            'supplier_profile_id' => $supplier->id,
            'product_ref' => 'PROD-' . strtoupper(Str::random(4)) . '-' . rand(1000, 9999), // Unique crypto track tokens block
            'product_category' => $productCategory,
            'product_name' => $productName,
            'price_pieces' => $pricePieces,
            'product_images' => $imagePathsCollection, // Auto encoded by model collection casts arrays logic rules
            'pcs_per_case' => $pcsPerCase,
            'cases_per_pallet' => $casesPerPallet,
            'pcs_per_pallet' => $pcsPerPallet,
            'overall_moqs' => $moqs,
            'production_capacity' => $capacity,
            'pricing_structure_type' => $pricingType,
            'full_truckload_details' => $ftlDetails,
            'payment_terms' => $terms,
            'ability_to_provide_samples' => $samples,
            'shelf_life' => $life,
            'ean_upc_code' => $ean,
            'product_description' => $desc,
            'product_catalogue' => $cataloguePath,
        ]);

        // 4. Return success status updates straight back onto their monitoring dashboards view ledger panels
        return redirect()->back()->with('success', "Catalogue listing item tracking parameters for '{$productName}' saved completely.");
    }

}
