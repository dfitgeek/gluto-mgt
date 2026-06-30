<div class="flex-1 mx-auto my-4 p-gutter w-full max-w-[1440px]" x-data="{ creationMethod: 'manual' }">

    <div class="flex sm:flex-row flex-col justify-between sm:items-center gap-4 mb-6 pb-4 border-b border-outline-variant/30 select-none">
        <div>
            <h2 class="font-headline-lg font-bold text-headline-lg text-primary text-2xl">Expand Inventory Catalogue</h2>
            <p class="mt-1 font-body-sm text-on-surface-variant text-sm">Add item specifications to your corporate index catalog manually or upload bulk asset datasheets.</p>
        </div>

        <div class="flex bg-surface-container p-1 border rounded-xl border-outline-variant/20 w-fit">
            <button type="button" @click="creationMethod = 'manual'"
                class="px-4 py-2 rounded-lg font-bold text-xs transition-all cursor-pointer"
                :class="creationMethod === 'manual' ? 'bg-white text-primary shadow-sm' : 'text-on-surface-variant hover:text-primary'">
                <span class="flex items-center gap-1.5"><span class="text-[16px] material-symbols-outlined">edit_note</span> Manual Input</span>
            </button>
            <button type="button" @click="creationMethod = 'upload'"
                class="px-4 py-2 rounded-lg font-bold text-xs transition-all cursor-pointer"
                :class="creationMethod === 'upload' ? 'bg-white text-primary shadow-sm' : 'text-on-surface-variant hover:text-primary'">
                <span class="flex items-center gap-1.5"><span class="text-[16px] material-symbols-outlined">cloud_upload</span> Upload PDF / XLSX Sheet</span>
            </button>
        </div>
    </div>

    @if(session()->has('success'))
        <div class="flex items-center gap-2 bg-emerald-50 mb-6 p-4 border border-emerald-200 rounded-xl font-semibold text-emerald-800 text-xs animate-fadeIn select-none">
            <span class="text-[18px] material-symbols-outlined">check_circle</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <form action="{{ route('supplier.products.store') }}" method="post" enctype="multipart/form-data" class="space-y-6">
        @csrf
        <input type="hidden" name="submission_method" :value="creationMethod">

        <div x-show="creationMethod === 'manual'" class="space-y-6 animate-fadeIn" x-cloak>
            <div class="space-y-6 bg-white shadow-sm p-8 border rounded-[2rem] border-outline-variant/40">
                <h3 class="flex items-center gap-2 pb-3 border-background border-b font-headline-md font-bold text-primary text-base select-none">
                    <span class="material-symbols-outlined">info</span> Core Identification & Details
                </h3>

                <div class="gap-6 grid grid-cols-1 md:grid-cols-3">
                    <div class="space-y-1.5">
                        <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Product Item Name *</label>
                        <input type="text" name="product_name" :disabled="creationMethod !== 'manual'" :required="creationMethod === 'manual'" class="bg-surface-container-low focus:bg-white px-4 py-2.5 border rounded-xl border-outline-variant outline-none focus:ring-1 focus:ring-primary w-full font-medium text-sm" placeholder="e.g., Organic Whole Wheat Flour">
                    </div>
                    <div class="space-y-1.5">
                        <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Product Origin</label>
                        <input type="text" name="product_origin" :disabled="creationMethod !== 'manual'"
                            class="bg-surface-container-low focus:bg-white px-4 py-2.5 border rounded-xl border-outline-variant outline-none focus:ring-1 focus:ring-primary w-full font-mono text-sm"
                            placeholder="e.g., 123 Exammple Street, Apapa, Lagos - Nigeria">
                    </div>
                    <div class="space-y-1.5">
                        <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Product Category Classification *</label>
                        <select name="product_category" :disabled="creationMethod !== 'manual'" class="bg-surface-container-low focus:bg-white px-4 py-2.5 border rounded-xl border-outline-variant outline-none focus:ring-1 focus:ring-primary w-full font-medium text-sm">
                            <option value="Organic">Organic Certified</option>
                            <option value="Gluten-Free">Gluten-Free Specialties</option>
                            <option value="Non-Gluten">Standard Non-Gluten</option>
                            <option value="FMCG">FMCG Retail Pack</option>
                        </select>
                    </div>
                    <div class="space-y-1.5">
                        <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">UPC / EAN Barcode Code</label>
                        <input type="text" name="ean_upc_code" :disabled="creationMethod !== 'manual'" class="bg-surface-container-low focus:bg-white px-4 py-2.5 border rounded-xl border-outline-variant outline-none focus:ring-1 focus:ring-primary w-full font-mono text-sm" placeholder="e.g., 012345678901">
                    </div>
                    <div class="space-y-1.5">
                        <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Product Expected Shelf Life</label>
                        <input type="text" name="shelf_life" :disabled="creationMethod !== 'manual'" class="bg-surface-container-low focus:bg-white px-4 py-2.5 border rounded-xl border-outline-variant outline-none focus:ring-1 focus:ring-primary w-full font-medium text-sm" placeholder="e.g., 18 Months">
                    </div>
                    <div class="space-y-1.5">
                        <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Unit Base Price (Pieces Valuation) *</label>
                        <div class="relative shadow-sm rounded-xl">
                            <div class="left-0 absolute inset-y-0 flex items-center pl-3 text-outline font-bold text-xs pointer-events-none">₦</div>
                            <input type="number" step="0.0001" name="price_pieces" :disabled="creationMethod !== 'manual'" :required="creationMethod === 'manual'" class="bg-surface-container-low focus:bg-white py-2.5 pr-4 pl-7 border rounded-xl border-outline-variant outline-none focus:ring-1 focus:ring-primary w-full font-mono text-sm" placeholder="0.0000">
                        </div>
                    </div>
                    <div class="space-y-1.5 md:col-span-3">
                        <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Comprehensive Product Description</label>
                        <textarea name="product_description" rows="3" :disabled="creationMethod !== 'manual'" class="bg-surface-container-low focus:bg-white px-4 py-2.5 border rounded-xl border-outline-variant outline-none focus:ring-1 focus:ring-primary w-full text-sm" placeholder="Detail component metrics, manufacturing language criteria, and geographic extraction origin notes..."></textarea>
                    </div>
                </div>

                <div class="space-y-2 pt-4 border-t border-dashed border-outline-variant/60">
                    <label class="block pl-0.5 font-bold text-primary text-xs">Upload Product Catalog Images (Select multiple up to 4 files) *</label>
                    <input type="file" name="product_images[]" :disabled="creationMethod !== 'manual'" :required="creationMethod === 'manual'" class="block hover:file:bg-primary/20 file:bg-primary/10 file:mr-4 file:file:px-4 file:file:py-2 file:border-0 file:rounded-xl w-full file:font-semibold text-on-surface-variant file:text-primary text-xs file:text-xs" accept="image/*" multiple>
                    <p class="pl-0.5 text-[10px] text-on-surface-variant">Accepts PNG, JPG formats up to 2MB per file instance.</p>
                </div>
            </div>

            <div class="space-y-6 bg-white shadow-sm p-8 border rounded-[2rem] border-outline-variant/40">
                <h3 class="flex items-center gap-2 pb-3 border-background border-b font-headline-md font-bold text-primary text-base select-none">
                    <span class="material-symbols-outlined">local_shipping</span> Section B: Logistical Packing & Commercial Terms
                </h3>
                <div class="gap-6 grid grid-cols-1 md:grid-cols-3">
                    <div class="space-y-1.5"><label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Pieces Per Case</label><input type="number" name="pcs_per_case" value="0" :disabled="creationMethod !== 'manual'" class="bg-surface-container-low px-4 py-2.5 border rounded-xl border-outline-variant w-full font-mono text-sm"></div>
                    <div class="space-y-1.5"><label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Cases Per Pallet</label><input type="number" name="cases_per_pallet" value="0" :disabled="creationMethod !== 'manual'" class="bg-surface-container-low px-4 py-2.5 border rounded-xl border-outline-variant w-full font-mono text-sm"></div>
                    <div class="space-y-1.5"><label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Pieces Per Pallet</label><input type="number" name="pcs_per_pallet" value="0" :disabled="creationMethod !== 'manual'" class="bg-surface-container-low px-4 py-2.5 border rounded-xl border-outline-variant w-full font-mono text-sm"></div>
                    <div class="space-y-1.5"><label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Minimum Order Quantity (MOQ)</label><input type="text" name="overall_moqs" :disabled="creationMethod !== 'manual'" class="bg-surface-container-low px-4 py-2.5 border rounded-xl border-outline-variant w-full text-sm" placeholder="e.g., 50 Cases"></div>
                    <div class="space-y-1.5"><label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Production/Supply Capacity</label><input type="text" name="production_capacity" :disabled="creationMethod !== 'manual'" class="bg-surface-container-low px-4 py-2.5 border rounded-xl border-outline-variant w-full text-sm" placeholder="e.g., 10,000 units/mo"></div>
                    <div class="space-y-1.5"><label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Pricing Structure Configuration</label><input type="text" name="pricing_structure_type" :disabled="creationMethod !== 'manual'" class="bg-surface-container-low px-4 py-2.5 border rounded-xl border-outline-variant w-full text-sm" placeholder="e.g., Tiered Bulk Rates"></div>
                    <div class="flex items-center gap-3 md:col-span-3 bg-surface-container-lowest px-4 py-3 border border-dashed rounded-xl"><input type="checkbox" name="ability_to_provide_samples" value="1" id="samples_toggle" :disabled="creationMethod !== 'manual'" class="rounded w-4 h-4 text-primary"><label for="samples_toggle" class="font-semibold text-on-surface-variant text-xs cursor-pointer select-none">We provide physical evaluation samples of this item to corporate buyers upon verified requests</label></div>
                    <div class="space-y-1.5 md:col-span-3"><label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Full Truckload (FTL) Logistics Specification Details</label><input type="text" name="full_truckload_details" :disabled="creationMethod !== 'manual'" class="bg-surface-container-low px-4 py-2.5 border rounded-xl border-outline-variant w-full text-sm" placeholder="FTL rules..."></div>
                    <div class="space-y-1.5 md:col-span-3"><label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Payment Terms Settlement Schedule</label><textarea name="payment_terms" rows="2" :disabled="creationMethod !== 'manual'" class="bg-surface-container-low px-4 py-2.5 border rounded-xl border-outline-variant w-full text-sm" placeholder="Net 30 days..."></textarea></div>
                </div>
            </div>
        </div>

        <div x-show="creationMethod === 'upload'" x-cloak class="space-y-6 animate-fadeIn">
            <div class="space-y-6 bg-white shadow-sm p-8 border rounded-[2rem] border-outline-variant/40">
                <h3 class="flex items-center gap-2 pb-3 border-background border-b font-headline-md font-bold text-primary text-base select-none">
                    <span class="material-symbols-outlined">analytics</span> Step 1: Attach Compiled Catalog Sheet
                </h3>

                <div class="flex flex-col justify-center items-center space-y-3 bg-surface-container-low/30 p-12 border-2 border-dashed rounded-2xl border-outline-variant/60 text-center select-none">
                    <div class="flex justify-center items-center bg-primary/5 rounded-full w-12 h-12 text-primary">
                        <span class="text-[28px] material-symbols-outlined">picture_as_pdf</span>
                    </div>
                    <div class="space-y-1">
                        <label class="block font-label-md font-bold text-primary text-sm cursor-pointer">
                            <span class="inline-block bg-primary hover:bg-primary/95 shadow-sm px-5 py-2 rounded-xl text-white text-xs transition-all">Choose Catalogue Document</span>
                            <input type="file" name="product_catalogue" :disabled="creationMethod !== 'upload'" :required="creationMethod === 'upload'" class="hidden" accept=".pdf,.xls,.xlsx" onchange="document.getElementById('catalog-file-info').innerText = this.files[0] ? this.files[0].name + ' (' + (this.files[0].size/1024/1024).toFixed(2) + ' MB)' : 'No template datasheet chosen';">
                        </label>
                        <p id="catalog-file-info" class="mt-2 font-mono font-bold text-secondary text-xs tracking-wide">No template datasheet chosen</p>
                    </div>
                    <p class="text-[10px] text-on-surface-variant/80">Supports PDF spreadsheets or Excel XLSX workbooks up to 10MB.</p>
                </div>

                <div class="gap-6 grid grid-cols-1 md:grid-cols-3 pt-4 border-t border-dashed">
                    <div class="space-y-1.5 md:col-span-2">
                        <label class="block font-bold text-on-surface-variant text-xs">General Catalog Title Name (For Identification) *</label>
                        <input type="text" name="bulk_product_name" :disabled="creationMethod !== 'upload'" :required="creationMethod === 'upload'" class="bg-surface-container-low px-4 py-2.5 border rounded-xl border-outline-variant w-full font-medium text-sm" placeholder="e.g., Q3 Corporate Flour Commodity Catalogue Stack">
                    </div>
                    <div class="space-y-1.5">
                        <label class="block font-bold text-on-surface-variant text-xs">Primary Category Cluster Mapping *</label>
                        <select name="bulk_product_category" :disabled="creationMethod !== 'upload'" class="bg-surface-container-low focus:bg-white px-4 py-2.5 border rounded-xl border-outline-variant outline-none focus:ring-1 focus:ring-primary w-full font-medium text-sm">
                            <option value="Organic">Organic Certified</option>
                            <option value="Gluten-Free">Gluten-Free Specialties</option>
                            <option value="Non-Gluten">Standard Non-Gluten</option>
                            <option value="FMCG">FMCG Retail Pack</option>
                        </select>
                    </div>

                    <div class="space-y-1.5">
                        <label class="block font-bold text-on-surface-variant text-xs">UPC / EAN Barcode Code</label>
                        <input type="text" name="bulk_ean_upc_code" :disabled="creationMethod !== 'upload'" class="bg-surface-container-low px-4 py-2.5 border rounded-xl border-outline-variant w-full font-mono text-sm" placeholder="Barcode tracking">
                    </div>
                    <div class="space-y-1.5">
                        <label class="block font-bold text-on-surface-variant text-xs">Product Expected Shelf Life</label>
                        <input type="text" name="bulk_shelf_life" :disabled="creationMethod !== 'upload'" class="bg-surface-container-low px-4 py-2.5 border rounded-xl border-outline-variant w-full text-sm" placeholder="e.g., 24 Months">
                    </div>
                    <div class="space-y-1.5">
                        <label class="block font-bold text-on-surface-variant text-xs">Base Unit Starting Valuation Price *</label>
                        <div class="relative shadow-sm rounded-xl">
                            <div class="left-0 absolute inset-y-0 flex items-center pl-3 text-outline font-bold text-xs pointer-events-none">₦</div>
                            <input type="number" step="0.0001" name="bulk_price_pieces" :disabled="creationMethod !== 'upload'" :required="creationMethod === 'upload'" class="bg-surface-container-low focus:bg-white py-2.5 pr-4 pl-7 border rounded-xl border-outline-variant outline-none focus:ring-1 focus:ring-primary w-full font-mono text-sm" placeholder="0.0000">
                        </div>
                    </div>

                    <div class="space-y-1.5"><label class="block font-bold text-on-surface-variant text-xs">Pieces Per Case (Pcs/Case)</label><input type="number" name="bulk_pcs_per_case" value="0" :disabled="creationMethod !== 'upload'" class="bg-surface-container-low px-4 py-2.5 border rounded-xl border-outline-variant w-full font-mono text-sm"></div>
                    <div class="space-y-1.5"><label class="block font-bold text-on-surface-variant text-xs">Cases Per Pallet</label><input type="number" name="bulk_cases_per_pallet" value="0" :disabled="creationMethod !== 'upload'" class="bg-surface-container-low px-4 py-2.5 border rounded-xl border-outline-variant w-full font-mono text-sm"></div>
                    <div class="space-y-1.5"><label class="block font-bold text-on-surface-variant text-xs">Pieces Per Pallet</label><input type="number" name="bulk_pcs_per_pallet" value="0" :disabled="creationMethod !== 'upload'" class="bg-surface-container-low px-4 py-2.5 border rounded-xl border-outline-variant w-full font-mono text-sm"></div>

                    <div class="space-y-1.5"><label class="block font-bold text-on-surface-variant text-xs">Minimum Order Quantity (MOQ)</label><input type="text" name="bulk_overall_moqs" :disabled="creationMethod !== 'upload'" class="bg-surface-container-low px-4 py-2.5 border rounded-xl border-outline-variant w-full text-sm" placeholder="Global sheet MOQ scale"></div>
                    <div class="space-y-1.5"><label class="block font-bold text-on-surface-variant text-xs">Production/Supply Capacity</label><input type="text" name="bulk_production_capacity" :disabled="creationMethod !== 'upload'" class="bg-surface-container-low px-4 py-2.5 border rounded-xl border-outline-variant w-full text-sm" placeholder="Monthly metrics"></div>
                    <div class="flex items-center gap-3 md:col-span-3 bg-surface-container-lowest px-4 py-3 border border-dashed rounded-xl"><input type="checkbox" name="bulk_ability_to_provide_samples" value="1" id="bulk_samples_toggle" :disabled="creationMethod !== 'upload'" class="rounded w-4 h-4 text-primary"><label for="bulk_samples_toggle" class="font-semibold text-on-surface-variant text-xs cursor-pointer select-none">We provide physical evaluation samples of items listed inside this bulk catalog workbook</label></div>
                </div>
            </div>
        </div>

        <div class="flex sm:flex-row flex-col justify-between items-start sm:items-center gap-4 bg-surface-container-low shadow-inner p-5 border rounded-2xl border-outline-variant/40 select-none">
            <div class="flex items-center gap-2 font-semibold text-on-surface-variant text-xs">
                <span class="text-[18px] text-primary material-symbols-outlined">security</span>
                <span>Active Vendor session guard token verified: <strong>{{ auth('supplier')->user()->supplier_ref_number }}</strong></span>
            </div>
            <button type="submit" class="flex justify-center items-center gap-2 bg-primary hover:bg-primary/95 shadow-lg shadow-primary/10 px-8 py-3.5 rounded-xl w-full sm:w-auto font-label-md font-bold text-white text-xs active:scale-95 transition-transform cursor-pointer">
                Commit Catalogue Profile <span class="material-symbols-outlined">save_as</span>
            </button>
        </div>
    </form>
</div>
