<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Add Tourism Destination</h1>
        <a href="<?= Env::get('APP_URL') ?>/admin/tourism" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back to Tourism
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-body">
                    <form action="<?= Env::get('APP_URL') ?>/admin/tourism/store" method="POST">
                        <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($this->generateCsrf()) ?>">

                        <div class="mb-3">
                            <label class="form-label">Name *</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Location *</label>
                            <input type="text" name="location" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Ticket Price</label>
                            <input type="number" name="ticket_price" class="form-control" min="0" value="0">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Recommended Vehicle</label>
                            <input type="text" name="recommended_vehicle" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Maps Embed URL</label>
                            <textarea name="maps_embed_url" class="form-control" rows="3"></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="4"></textarea>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Save Destination</button>
                            <a href="<?= Env::get('APP_URL') ?>/admin/tourism" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
