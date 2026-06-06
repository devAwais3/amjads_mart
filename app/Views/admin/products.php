<?php $activePage = 'products'; ?>
<?php include __DIR__ . '/partials/header.php'; ?>
<?php include __DIR__ . '/partials/sidebar.php'; ?>

<div class="admin-main">
    <div class="admin-header">
        <h1>🛍️ Products</h1>
        <button class="btn btn-primary" id="add-product-btn" data-bs-toggle="modal" data-bs-target="#productModal">
            <i class="ri-add-line"></i> Add Product
        </button>
    </div>

    <!-- Search/Filter -->
    <div class="admin-card mb-4">
        <form method="GET" style="display:flex;gap:.75rem;flex-wrap:wrap;align-items:flex-end">
            <div style="flex:1;min-width:200px">
                <label style="font-size:.82rem;font-weight:600;display:block;margin-bottom:.3rem">Search</label>
                <input type="text" name="search" class="form-control" placeholder="Product name..."
                    value="<?= esc($search) ?>">
            </div>
            <div>
                <label style="font-size:.82rem;font-weight:600;display:block;margin-bottom:.3rem">Category</label>
                <select name="category" class="form-control">
                    <option value="">All Categories</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>"><?= esc($cat['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-outline"><i class="ri-search-line"></i> Filter</button>
        </form>
    </div>

    <!-- Products Table -->
    <div class="admin-card">
        <div style="overflow-x:auto">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $p): ?>
                        <tr>
                            <td><img src="/<?= esc($p['image_url']) ?>" onerror="this.src='/assets/images/placeholder.jpg'"
                                    alt=""></td>
                            <td>
                                <strong><?= esc($p['name']) ?></strong>
                                <div style="font-size:.75rem;color:var(--gray)"><?= esc($p['unit']) ?></div>
                            </td>
                            <td><?= esc($p['category_name'] ?? '—') ?></td>
                            <td>
                                <strong>Rs. <?= number_format($p['price'], 0) ?></strong>
                                <?php if ($p['original_price']): ?>
                                    <div style="font-size:.75rem;color:var(--gray);text-decoration:line-through">Rs.
                                        <?= number_format($p['original_price'], 0) ?>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span style="<?= $p['stock'] < 10 ? 'color:var(--red);font-weight:700' : '' ?>">
                                    <?= $p['stock'] ?>
                                </span>
                            </td>
                            <td>
                                <?php if ($p['is_featured']): ?><span class="order-status-badge status-delivered"
                                        style="font-size:.7rem">Featured</span><?php endif; ?>
                                <?php if ($p['is_on_sale']): ?><span class="order-status-badge status-processing"
                                        style="font-size:.7rem">Sale</span><?php endif; ?>
                                <?php if (!$p['is_active']): ?><span class="order-status-badge status-cancelled"
                                        style="font-size:.7rem">Inactive</span><?php endif; ?>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-outline btn-edit-product" data-id="<?= $p['id'] ?>"
                                    data-bs-toggle="modal" data-bs-target="#productModal">
                                    <i class="ri-edit-line"></i>
                                </button>
                                <button class="btn btn-sm btn-red btn-delete-product" data-id="<?= $p['id'] ?>"
                                    style="margin-left:.25rem">
                                    <i class="ri-delete-bin-6-line"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Product Modal -->
<div class="modal fade" id="productModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius:16px;border:none">
            <div class="modal-header" style="border-bottom:1px solid var(--gray-l)">
                <h5 class="modal-title" id="product-modal-title">Add Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form id="product-form" enctype="multipart/form-data">
                    <div class="row g-3">
                        <div class="col-sm-8">
                            <label class="fw-600 d-block mb-1" style="font-size:.85rem">Product Name *</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="col-sm-4">
                            <label class="fw-600 d-block mb-1" style="font-size:.85rem">Category *</label>
                            <select name="category_id" class="form-control" required>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?= $cat['id'] ?>"><?= esc($cat['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <label class="fw-600 d-block mb-1" style="font-size:.85rem">Price (Rs.) *</label>
                            <input type="number" name="price" class="form-control" step="0.01" min="0" required>
                        </div>
                        <div class="col-sm-4">
                            <label class="fw-600 d-block mb-1" style="font-size:.85rem">Original Price (Rs.)</label>
                            <input type="number" name="original_price" class="form-control" step="0.01" min="0">
                        </div>
                        <div class="col-sm-2">
                            <label class="fw-600 d-block mb-1" style="font-size:.85rem">Discount %</label>
                            <input type="number" name="discount_percent" class="form-control" min="0" max="100"
                                value="0">
                        </div>
                        <div class="col-sm-2">
                            <label class="fw-600 d-block mb-1" style="font-size:.85rem">Stock</label>
                            <input type="number" name="stock" class="form-control" min="0" value="0" required>
                        </div>
                        <div class="col-sm-6">
                            <label class="fw-600 d-block mb-1" style="font-size:.85rem">Unit</label>
                            <input type="text" name="unit" class="form-control"
                                placeholder="e.g. 1kg bag, 500ml bottle">
                        </div>
                        <div class="col-sm-6">
                            <label class="fw-600 d-block mb-1" style="font-size:.85rem">Product Image</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                        </div>
                        <div class="col-12">
                            <label class="fw-600 d-block mb-1" style="font-size:.85rem">Description</label>
                            <textarea name="description" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="col-sm-6" style="display:flex;align-items:center;gap:1.5rem;margin-top:.25rem">
                            <label
                                style="display:flex;align-items:center;gap:.4rem;cursor:pointer;font-size:.88rem;font-weight:600">
                                <input type="checkbox" name="is_featured"> Featured ⭐
                            </label>
                            <label
                                style="display:flex;align-items:center;gap:.4rem;cursor:pointer;font-size:.88rem;font-weight:600">
                                <input type="checkbox" name="is_on_sale"> On Sale 🔥
                            </label>
                        </div>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="ri-save-line"></i> Save Product
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--
<link rel="stylesheet" href="/assets/css/style.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@4.1.0/fonts/remixicon.css">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
    rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="/assets/js/admin.js"></script>
-->
</div>

