<!-- Item Submission Form -->
<div class="container mt-5">
    <h2 class="text-center">Want to Sell An Item? Add It Here!</h2>
    <div class="row justify-content-center">
        <div class="col-md-6"> <!-- Form is now limited to 6 out of 12 columns on medium or larger screens -->
            <div class="form-section">
                <form action="../php/submit_item.php" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="itemTitle">Item Title</label>
                        <input type="text" class="form-control" id="itemTitle" name="itemTitle" placeholder="Enter item title" required>
                    </div>
                    <div class="mb-3">
                        <label for="description">Item Description</label>
                        <textarea class="form-control" id="itemDescription" name="itemDescription" rows="3" placeholder="Enter item description" required></textarea>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <label for="city">City</label>
                            <input type="text" class="form-control" id="city" name="city" placeholder="Enter city" required>
                        </div>
                        <div class="col-sm-6">
                            <label for="state">State</label>
                            <input type="text" class="form-control" id="state" name="state" placeholder="Enter state" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <label for="price">Price</label>
                            <input type="number" class="form-control" id="price" name="price" placeholder="Enter price" required>
                        </div>
                        <div class="col-sm-6">
                            <label for="state">Condition</label>
                            <input type="text" class="form-control" id="condition" name="condition" placeholder="Enter Condition" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="image">Upload Item Image</label>
                        <input type="file" class="form-control" id="image" name="image[]" multiple required>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Submit Item</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>