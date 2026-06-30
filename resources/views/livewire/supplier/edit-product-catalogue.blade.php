<div class="flex-1 mx-auto my-4 p-gutter w-full max-w-[1440px]" x-data="{ creationMethod: '{{ $initialMethod }}' }">

    <div
        class="flex sm:flex-row flex-col justify-between sm:items-center gap-4 mb-6 pb-4 border-b border-outline-variant/30">
        <div>
            <h2 class="font-headline-lg font-bold text-headline-lg text-primary text-2xl">Modify Catalogue Parameters
            </h2>
            <p class="mt-1 font-body-sm text-on-surface-variant text-sm">Update product identity details, logistics
                specs, or replace the active bulk datasheet archive.</p>
        </div>

        <div class="flex bg-surface-container p-1 border rounded-xl border-outline-variant/20 w-fit select-none">
            <button type="button" @click="creationMethod = 'manual'"
                class="px-4 py-2 rounded-lg font-bold text-xs transition-all cursor-pointer"
                :class="creationMethod === 'manual' ? 'bg-white text-primary shadow-sm' : 'text-on-surface-variant hover:text-primary'">
                <span class="flex items-center gap-1.5"><span
                        class="text-[16px] material-symbols-outlined">edit_note</span> Manual Specifications</span>
            </button>
            <button type="button" @click="creationMethod = 'upload'"
                class="px-4 py-2 rounded-lg font-bold text-xs transition-all cursor-pointer"
                :class="creationMethod === 'upload' ? 'bg-white text-primary shadow-sm' : 'text-on-surface-variant hover:text-primary'">
                <span class="flex items-center gap-1.5"><span
                        class="text-[16px] material-symbols-outlined">cloud_upload</span> Bulk Catalog File</span>
            </button>
        </div>
    </div>

    @if(session()->has('success'))
        <div
            class="flex items-center gap-2 bg-emerald-50 mb-6 p-4 border border-emerald-200 rounded-xl font-semibold text-emerald-800 text-xs animate-fadeIn">
            <span class="text-[18px] material-symbols-outlined">check_circle</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-50 mb-6 p-4 border border-red-200 rounded-xl font-medium text-red-800 text-xs animate-fadeIn">
            <ul class="space-y-0.5 list-disc list-inside">
                @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('supplier.products.update', ['id' => $productId]) }}" method="post"
        enctype="multipart/form-data" class="space-y-6">
        @csrf
        <input type="hidden" name="submission_method" :value="creationMethod">

        <div x-show="creationMethod === 'manual'" class="space-y-6 animate-fadeIn" x-cloak>
            <div class="space-y-6 bg-white shadow-sm p-8 border rounded-[2rem] border-outline-variant/40">
                <h3
                    class="flex items-center gap-2 pb-3 border-background border-b font-headline-md font-bold text-primary text-base">
                    <span class="material-symbols-outlined">info</span> Core Identification & Details
                </h3>

                <div class="gap-6 grid grid-cols-1 md:grid-cols-3">
                    <div class="space-y-1.5">
                        <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Product Item Name
                            *</label>
                        <input type="text" name="product_name" value="{{ old('product_name', $product->product_name) }}"
                            :disabled="creationMethod !== 'manual'" :required="creationMethod === 'manual'"
                            class="bg-surface-container-low focus:bg-white px-4 py-2.5 border rounded-xl border-outline-variant outline-none focus:ring-1 focus:ring-primary w-full font-medium text-sm">
                    </div>

                    <div class="space-y-1.5">
                        <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Product Origin</label>
                        <div class="relative shadow-sm rounded-xl">
                            <input type="text" step="0.0001" name="product_origin"
                                value="{{ old('product_origin', $product->product_origin) }}"
                                :disabled="creationMethod !== 'manual'" :required="creationMethod === 'manual'"
                                class="bg-surface-container-low focus:bg-white px-4 py-2.5 pr-4 border rounded-xl border-outline-variant outline-none focus:ring-1 focus:ring-primary w-full font-mono text-sm"  placeholder="e.g., 123 Exammple Street, Apapa, Lagos - Nigeria">
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Product Category *</label>
                        <select name="product_category" :disabled="creationMethod !== 'manual'"
                            class="bg-surface-container-low focus:bg-white px-4 py-2.5 border rounded-xl border-outline-variant outline-none focus:ring-1 focus:ring-primary w-full font-medium text-sm">
                            @foreach(['Organic' => 'Organic Certified', 'Gluten-Free' => 'Gluten-Free Specialties', 'Non-Gluten' => 'Standard Non-Gluten', 'FMCG' => 'FMCG Retail Pack'] as $val => $lbl)
                                <option value="{{ $val }}" {{ old('product_category', $product->product_category) === $val ? 'selected' : '' }}>{{ $lbl }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="space-y-1.5">
                        <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">UPC / EAN Barcode
                            Code</label>
                        <input type="text" name="ean_upc_code" value="{{ old('ean_upc_code', $product->ean_upc_code) }}"
                            :disabled="creationMethod !== 'manual'"
                            class="bg-surface-container-low focus:bg-white px-4 py-2.5 border rounded-xl border-outline-variant outline-none focus:ring-1 focus:ring-primary w-full font-mono text-sm">
                    </div>
                    <div class="space-y-1.5">
                        <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Product Expected Shelf
                            Life</label>
                        <input type="text" name="shelf_life" value="{{ old('shelf_life', $product->shelf_life) }}"
                            :disabled="creationMethod !== 'manual'"
                            class="bg-surface-container-low focus:bg-white px-4 py-2.5 border rounded-xl border-outline-variant outline-none focus:ring-1 focus:ring-primary w-full font-medium text-sm">
                    </div>
                    <div class="space-y-1.5">
                        <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Unit Base Price (Pieces
                            Valuation) *</label>
                        <div class="relative shadow-sm rounded-xl">
                            <div
                                class="left-0 absolute inset-y-0 flex items-center pl-3 text-outline font-bold text-xs pointer-events-none">
                                ₦</div>
                            <input type="number" step="0.0001" name="price_pieces"
                                value="{{ old('price_pieces', $product->price_pieces) }}"
                                :disabled="creationMethod !== 'manual'" :required="creationMethod === 'manual'"
                                class="bg-surface-container-low focus:bg-white py-2.5 pr-4 pl-7 border rounded-xl border-outline-variant outline-none focus:ring-1 focus:ring-primary w-full font-mono text-sm">
                        </div>
                    </div>

                    <div class="space-y-1.5 md:col-span-3">
                        <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Comprehensive Product
                            Description</label>
                        <textarea name="product_description" rows="3" :disabled="creationMethod !== 'manual'"
                            class="bg-surface-container-low focus:bg-white px-4 py-2.5 border rounded-xl border-outline-variant outline-none focus:ring-1 focus:ring-primary w-full text-sm">{{ old('product_description', $product->product_description) }}</textarea>
                    </div>
                </div>

                <div class="space-y-4 pt-4 border-t border-dashed border-outline-variant/60">
                    <div>
                        <label class="block pl-0.5 font-bold text-primary text-xs">Active Catalog Image Gallery</label>
                        <p class="pl-0.5 text-[11px] text-on-surface-variant/80">Uploading new file streams below will
                            replace the active image stack entirely.</p>
                    </div>

                    @if(filled($product->product_images))
                        <div class="gap-4 grid grid-cols-2 sm:grid-cols-4 max-w-2xl select-none">
                            @foreach($product->product_images as $pathNode)
                                <div
                                    class="relative flex justify-center items-center bg-background shadow-inner border rounded-xl aspect-[4/3] overflow-hidden">
                                    <img src="{{ asset('storage/' . $pathNode) }}" class="w-full h-full object-cover">
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <div class="space-y-2 pt-2">
                        <label class="block pl-0.5 font-semibold text-on-surface-variant text-xs">Upload Replacement
                            Product Images (Optional, max 4 files)</label>
                        <input type="file" name="product_images[]" :disabled="creationMethod !== 'manual'"
                            class="block hover:file:bg-primary/20 file:bg-primary/10 file:mr-4 file:px-4 file:py-2 file:border-0 file:rounded-xl w-full file:font-semibold text-on-surface-variant file:text-primary text-xs"
                            accept="image/*" multiple>
                    </div>
                </div>
            </div>

            <div class="space-y-6 bg-white shadow-sm p-8 border rounded-[2rem] border-outline-variant/40">
                <h3
                    class="flex items-center gap-2 pb-3 border-background border-b font-headline-md font-bold text-primary text-base">
                    <span class="material-symbols-outlined">local_shipping</span> Section B: Logistical Packing &
                    Commercial Terms
                </h3>

                <div class="gap-6 grid grid-cols-1 md:grid-cols-3">
                    <div class="space-y-1.5">
                        <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Pieces Per Case
                            (Pcs/Case)</label>
                        <input type="number" name="pcs_per_case"
                            value="{{ old('pcs_per_case', $product->pcs_per_case) }}"
                            :disabled="creationMethod !== 'manual'"
                            class="bg-surface-container-low px-4 py-2.5 border rounded-xl border-outline-variant w-full font-mono text-sm">
                    </div>
                    <div class="space-y-1.5">
                        <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Cases Per Pallet</label>
                        <input type="number" name="cases_per_pallet"
                            value="{{ old('cases_per_pallet', $product->cases_per_pallet) }}"
                            :disabled="creationMethod !== 'manual'"
                            class="bg-surface-container-low px-4 py-2.5 border rounded-xl border-outline-variant w-full font-mono text-sm">
                    </div>
                    <div class="space-y-1.5">
                        <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Pieces Per Pallet
                            (Pcs/Pallet)</label>
                        <input type="number" name="pcs_per_pallet"
                            value="{{ old('pcs_per_pallet', $product->pcs_per_pallet) }}"
                            :disabled="creationMethod !== 'manual'"
                            class="bg-surface-container-low px-4 py-2.5 border rounded-xl border-outline-variant w-full font-mono text-sm">
                    </div>
                    <div class="space-y-1.5">
                        <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Minimum Order Quantity
                            (MOQ)</label>
                        <input type="text" name="overall_moqs" value="{{ old('overall_moqs', $product->overall_moqs) }}"
                            :disabled="creationMethod !== 'manual'"
                            class="bg-surface-container-low px-4 py-2.5 border rounded-xl border-outline-variant w-full text-sm">
                    </div>
                    <div class="space-y-1.5">
                        <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Production/Supply
                            Capacity</label>
                        <input type="text" name="production_capacity"
                            value="{{ old('production_capacity', $product->production_capacity) }}"
                            :disabled="creationMethod !== 'manual'"
                            class="bg-surface-container-low px-4 py-2.5 border rounded-xl border-outline-variant w-full text-sm">
                    </div>
                    <div class="space-y-1.5">
                        <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Pricing Structure
                            Configuration</label>
                        <input type="text" name="pricing_structure_type"
                            value="{{ old('pricing_structure_type', $product->pricing_structure_type) }}"
                            :disabled="creationMethod !== 'manual'"
                            class="bg-surface-container-low px-4 py-2.5 border rounded-xl border-outline-variant w-full text-sm">
                    </div>

                    <div
                        class="flex items-center gap-3 md:col-span-3 bg-surface-container-lowest px-4 py-3 border border-dashed rounded-xl">
                        <input type="checkbox" name="ability_to_provide_samples" value="1" id="samples_toggle"
                            :disabled="creationMethod !== 'manual'" {{ old('ability_to_provide_samples', $product->ability_to_provide_samples) ? 'checked' : '' }}
                            class="rounded w-4 h-4 text-primary">
                        <label for="samples_toggle"
                            class="font-semibold text-on-surface-variant text-xs cursor-pointer select-none">We provide
                            physical evaluation samples of this item to corporate buyers upon verified requests</label>
                    </div>

                    <div class="space-y-1.5 md:col-span-3">
                        <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Full Truckload (FTL)
                            Logistics Specification Details</label>
                        <input type="text" name="full_truckload_details"
                            value="{{ old('full_truckload_details', $product->full_truckload_details) }}"
                            :disabled="creationMethod !== 'manual'"
                            class="bg-surface-container-low px-4 py-2.5 border rounded-xl border-outline-variant w-full text-sm">
                    </div>
                    <div class="space-y-1.5 md:col-span-3">
                        <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Payment Terms Settlement
                            Schedule</label>
                        <textarea name="payment_terms" rows="2" :disabled="creationMethod !== 'manual'"
                            class="bg-surface-container-low px-4 py-2.5 border rounded-xl border-outline-variant w-full text-sm">{{ old('payment_terms', $product->payment_terms) }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div x-show="creationMethod === 'upload'" x-cloak class="space-y-6 animate-fadeIn">
            <div class="space-y-6 bg-white shadow-sm p-8 border rounded-[2rem] border-outline-variant/40">
                <h3
                    class="flex items-center gap-2 pb-3 border-background border-b font-headline-md font-bold text-primary text-base">
                    <span class="material-symbols-outlined">analytics</span> Step 1: Attach Compiled Catalog Sheet
                </h3>

                @if($product->product_catalogue)
                    <div
                        class="flex justify-between items-center bg-primary/5 p-3.5 border border-primary/20 rounded-xl max-w-xl font-semibold text-primary text-xs select-none">
                        <span class="flex items-center gap-2"><span
                                class="text-[18px] material-symbols-outlined">cloud_done</span> Active Catalogue Sheet
                            Document is cached on file.</span>
                        <a href="{{ asset('storage/' . $product->product_catalogue) }}" target="_blank"
                            class="text-secondary hover:text-primary underline">Inspect Current Sheet</a>
                    </div>
                @endif

                <div
                    class="flex flex-col justify-center items-center space-y-3 bg-surface-container-low/30 p-12 border-2 border-dashed rounded-2xl border-outline-variant/60 text-center">
                    <div class="flex justify-center items-center bg-primary/5 rounded-full w-12 h-12 text-primary">
                        <span class="text-[28px] material-symbols-outlined">picture_as_pdf</span>
                    </div>
                    <div class="space-y-1">
                        <label class="block font-label-md font-bold text-primary text-sm cursor-pointer">
                            <span
                                class="inline-block bg-primary hover:bg-primary/95 shadow-sm px-5 py-2 rounded-xl text-white text-xs transition-all">Upload
                                Replacement Document</span>
                            <input type="file" name="product_catalogue" :disabled="creationMethod !== 'upload'"
                                @if(!$product->product_catalogue) required @endif class="hidden"
                                accept=".pdf,.xls,.xlsx"
                                onchange="document.getElementById('catalog-file-info').innerText = this.files[0] ? this.files[0].name + ' (' + (this.files[0].size/1024/1024).toFixed(2) + ' MB)' : 'No folder selection tracked';">
                        </label>
                        <p id="catalog-file-info" class="mt-2 font-mono font-bold text-secondary text-xs tracking-wide">
                            {{ $product->product_catalogue ? 'Leave empty to keep existing asset sheet file' : 'A bulk spreadsheet catalog document is mandatory *' }}
                        </p>
                    </div>
                    <p class="text-[10px] text-on-surface-variant/80">Supports PDF spreadsheets, Excel XLSX workbooks up
                        to 10MB.</p>
                </div>

                <div class="gap-4 grid grid-cols-1 md:grid-cols-2 pt-4 border-t border-dashed">
                    <div class="space-y-1.5 md:col-span-2">
                        <label class="block font-bold text-on-surface-variant text-xs">General Catalog Title Name (For
                            Identification) *</label>
                        <input type="text" name="bulk_product_name"
                            value="{{ old('bulk_product_name', $product->product_name) }}"
                            :disabled="creationMethod !== 'upload'" :required="creationMethod === 'upload'"
                            class="bg-surface-container-low px-4 py-2 border rounded-xl border-outline-variant w-full font-medium text-sm">
                    </div>
                    <div class="space-y-1.5">
                        <label class="block font-bold text-on-surface-variant text-xs">Primary Category Cluster Mapping
                            *</label>
                        <select name="bulk_product_category" :disabled="creationMethod !== 'upload'"
                            class="bg-surface-container-low focus:bg-white px-4 py-2.5 border rounded-xl border-outline-variant outline-none focus:ring-1 focus:ring-primary w-full font-medium text-sm">
                            @foreach(['Organic' => 'Organic Certified', 'Gluten-Free' => 'Gluten-Free Specialties', 'Non-Gluten' => 'Standard Non-Gluten', 'FMCG' => 'FMCG Retail Pack'] as $val => $lbl)
                                <option value="{{ $val }}" {{ old('bulk_product_category', $product->product_category) === $val ? 'selected' : '' }}>{{ $lbl }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-1.5">
                        <label class="block font-bold text-on-surface-variant text-xs">UPC / EAN Barcode Code</label>
                        <input type="text" name="bulk_ean_upc_code"
                            value="{{ old('bulk_ean_upc_code', $product->ean_upc_code) }}"
                            :disabled="creationMethod !== 'upload'"
                            class="bg-surface-container-low px-4 py-2.5 border rounded-xl border-outline-variant w-full font-mono text-sm"
                            placeholder="Barcode tracking">
                    </div>
                    <div class="space-y-1.5">
                        <label class="block font-bold text-on-surface-variant text-xs">Product Expected Shelf
                            Life</label>
                        <input type="text" name="bulk_shelf_life"
                            value="{{ old('bulk_shelf_life', $product->shelf_life) }}"
                            :disabled="creationMethod !== 'upload'"
                            class="bg-surface-container-low px-4 py-2.5 border rounded-xl border-outline-variant w-full text-sm"
                            placeholder="e.g., 24 Months">
                    </div>
                    <div class="space-y-1.5">
                        <label class="block font-bold text-on-surface-variant text-xs">Base Unit Starting Valuation
                            Price *</label>
                        <div class="relative shadow-sm rounded-xl">
                            <div
                                class="left-0 absolute inset-y-0 flex items-center pl-3 text-outline font-bold text-xs pointer-events-none">
                                ₦</div>
                            <input type="number" step="0.0001" name="bulk_price_pieces"
                                value="{{ old('bulk_price_pieces', $product->price_pieces) }}"
                                :disabled="creationMethod !== 'upload'" :required="creationMethod === 'upload'"
                                class="bg-surface-container-low focus:bg-white py-2.5 pr-4 pl-7 border rounded-xl border-outline-variant outline-none focus:ring-1 focus:ring-primary w-full font-mono text-sm">
                        </div>
                    </div>

                    <div class="space-y-1.5"><label class="block font-bold text-on-surface-variant text-xs">Pieces Per
                            Case (Pcs/Case)</label><input type="number" name="bulk_pcs_per_case"
                            value="{{ old('bulk_pcs_per_case', $product->pcs_per_case) }}"
                            :disabled="creationMethod !== 'upload'"
                            class="bg-surface-container-low px-4 py-2.5 border rounded-xl border-outline-variant w-full font-mono text-sm">
                    </div>
                    <div class="space-y-1.5"><label class="block font-bold text-on-surface-variant text-xs">Cases Per
                            Pallet</label><input type="number" name="bulk_cases_per_pallet"
                            value="{{ old('bulk_cases_per_pallet', $product->cases_per_pallet) }}"
                            :disabled="creationMethod !== 'upload'"
                            class="bg-surface-container-low px-4 py-2.5 border rounded-xl border-outline-variant w-full font-mono text-sm">
                    </div>
                    <div class="space-y-1.5"><label class="block font-bold text-on-surface-variant text-xs">Pieces Per
                            Pallet</label><input type="number" name="bulk_pcs_per_pallet"
                            value="{{ old('bulk_pcs_per_pallet', $product->pcs_per_pallet) }}"
                            :disabled="creationMethod !== 'upload'"
                            class="bg-surface-container-low px-4 py-2.5 border rounded-xl border-outline-variant w-full font-mono text-sm">
                    </div>

                    <div class="space-y-1.5"><label class="block font-bold text-on-surface-variant text-xs">Minimum
                            Order Quantity (MOQ)</label><input type="text" name="bulk_overall_moqs"
                            value="{{ old('bulk_overall_moqs', $product->overall_moqs) }}"
                            :disabled="creationMethod !== 'upload'"
                            class="bg-surface-container-low px-4 py-2.5 border rounded-xl border-outline-variant w-full text-sm">
                    </div>
                    <div class="space-y-1.5"><label
                            class="block font-bold text-on-surface-variant text-xs">Production/Supply
                            Capacity</label><input type="text" name="bulk_production_capacity"
                            value="{{ old('bulk_production_capacity', $product->production_capacity) }}"
                            :disabled="creationMethod !== 'upload'"
                            class="bg-surface-container-low px-4 py-2.5 border rounded-xl border-outline-variant w-full text-sm">
                    </div>
                    <div
                        class="flex items-center gap-3 md:col-span-3 bg-surface-container-lowest px-4 py-3 border border-dashed rounded-xl">
                        <input type="checkbox" name="bulk_ability_to_provide_samples" value="1" id="bulk_samples_toggle"
                            :disabled="creationMethod !== 'upload'" {{ old('bulk_ability_to_provide_samples', $product->ability_to_provide_samples) ? 'checked' : '' }}
                            class="rounded w-4 h-4 text-primary"><label for="bulk_samples_toggle"
                            class="font-semibold text-on-surface-variant text-xs cursor-pointer select-none">We provide
                            physical evaluation samples of items listed inside this bulk catalog workbook</label></div>
                </div>
            </div>
        </div>

        <div
            class="flex sm:flex-row flex-col justify-between items-start sm:items-center gap-4 bg-surface-container-low shadow-inner p-5 border rounded-2xl border-outline-variant/40">
            <div class="flex items-center gap-2 font-semibold text-on-surface-variant text-xs select-none">
                <span class="text-[18px] text-primary material-symbols-outlined">edit_attributes</span>
                <span>Modifying code item entity identifier token: <strong
                        class="font-mono text-primary">{{ $product->product_ref }}</strong></span>
            </div>
            <div class="flex justify-end gap-2.5 w-full sm:w-auto">
                <a href="{{ route('supplier.products') }}" wire:navigate
                    class="bg-white hover:bg-background px-5 py-3 border rounded-xl w-full sm:w-auto font-bold text-on-surface-variant text-xs text-center transition-colors">Cancel
                    Change</a>
                <button type="submit"
                    class="flex justify-center items-center gap-2 bg-primary hover:bg-primary/95 shadow-lg shadow-primary/10 px-8 py-3.5 rounded-xl w-full sm:w-auto font-label-md font-bold text-white text-xs active:scale-95 transition-transform cursor-pointer">
                    Save Modifications <span class="material-symbols-outlined">save_as</span>
                </button>
            </div>
        </div>
    </form>
</div>
