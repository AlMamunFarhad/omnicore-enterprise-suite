<div x-data="{ open: false }" x-show="open" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">

    <div class="bg-panel-bg rounded-lg shadow-lg w-full max-w-md">

        <div class="px-6 py-4 border-b border-border-subtle bg-red-500 text-white rounded-t-lg">

            <h3 class="font-semibold">
                Confirm Delete
            </h3>

        </div>

        <div class="p-6">

            <p class="text-secondary">
                Are you sure you want to delete this item?
            </p>

        </div>

        <div class="px-6 py-4 border-t border-border-subtle flex justify-end gap-3">

            <button type="button" @click="open = false" class="btn btn-secondary">

                Cancel

            </button>

            <button type="submit" class="btn btn-danger">

                Delete

            </button>

        </div>

    </div>

</div>
