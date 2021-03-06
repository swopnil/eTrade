<?php $__env->startSection('title', 'Product Categories'); ?>
<?php $__env->startSection('data-page-id', 'adminCategories'); ?>

<?php $__env->startSection('content'); ?>
    <!-- Start Category Display -->
    <div class="category grid-container fluid">
        <div class="grid-x grid-margin-x">
            <div class="cell large-12 medium-12 small-12">
                <h2>Product Categories</h2>
                <hr>
            </div>
        </div>

        <div class="grid-x grid-margin-x">
            <div class="cell large-6 medium-6 small-12">
                <form action="" method="post">
                    <div class="input-group">
                        <input type="text" class="input-group-field" placeholder="Search by name">
                        <div class="input-group-button">
                            <input type="submit" class="button" value="Search">
                        </div>
                    </div>
                </form>
            </div>
            <div class="cell large-6 medium-6 small-12 end">
                <form action="/admin/product/categories" method="post">
                    <div class="input-group">
                        <input type="text" class="input-group-field" name="name" placeholder="Category Name name">
                        <input type="hidden" name="token" value="<?php echo e(\App\Classes\CSRFToken::_token()); ?>">
                        <div class="input-group-button">
                            <input type="submit" class="button" value="Create">
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <?php echo $__env->make('includes.message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <div class="grid-x grid-margin-x">
            <div class="cell large-12 small-12 medium-12">
                <?php if(count($categories)): ?>
                    <table class="hover unstriped" data-form="deleteForm">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Date Created</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($category['name']); ?></td>
                                    <td><?php echo e($category['slug']); ?></td>
                                    <td><?php echo e($category['added']); ?></td>
                                    <td width="100" class="text-center">
                                        <span data-tooltip class="top" tabindex="2" title="Add Subcategory">
                                           <a data-open="add-subcategory-<?php echo e($category['id']); ?>"><i class="fa fa-plus"></i></a>
                                        </span>
                                        <span data-tooltip class="top" tabindex="2" title="Edit Category">
                                           <a data-open="item-<?php echo e($category['id']); ?>"><i class="fa fa-edit"></i></a>
                                        </span>
                                        <span style="display: inline-block" data-tooltip class="top" tabindex="2" title="Delete Category">
                                            <form action="/admin/product/categories/<?php echo e($category['id']); ?>/delete" method="post" class="delete-item">
                                                <input type="hidden" name="token" value="<?php echo e(\App\Classes\CSRFToken::_token()); ?>">
                                                <button type="submit"><i class="fa fa-times delete"></i></button>
                                            </form>
                                        </span>

                                        <!-- Start Edit Category Modal -->
                                        <div class="reveal" id="item-<?php echo e($category['id']); ?>" data-reveal data-close-on-click="false" data-close-on-esc="false" data-animation-in="scale-in-up">
                                            <div class="notification callout primary"></div>
                                            <h2>Edit Category</h2>
                                            <form>
                                                <div class="input-group">
                                                    <input type="text" id="item-name-<?php echo e($category['id']); ?>" name="name" value="<?php echo e($category['name']); ?>">
                                                    <div>
                                                        <input type="submit" class="button update-category" id="<?php echo e($category['id']); ?>" name="token" data-token="<?php echo e(\App\Classes\CSRFToken::_token()); ?>" value="Update">
                                                    </div>
                                                </div>
                                            </form>
                                            <a href="/admin/product/categories" class="close-button" aria-label="Close modal" type="button">
                                                <span aria-hidden="true">&times;</span>
                                            </a>
                                        </div>
                                        <!-- End Edit Category Modal -->

                                        <!-- Start Add Sub-Category Modal -->
                                        <div class="reveal" id="add-subcategory-<?php echo e($category['id']); ?>" data-reveal data-close-on-click="false" data-close-on-esc="false" data-animation-in="scale-in-up">
                                            <div class="notification callout primary"></div>
                                            <h2>Add Sub-Category</h2>
                                            <form>
                                                <div class="input-group">
                                                    <input type="text" id="subcategory-name-<?php echo e($category['id']); ?>">
                                                    <div>
                                                        <input type="submit" class="button add-subcategory" id="<?php echo e($category['id']); ?>" name="token" data-token="<?php echo e(\App\Classes\CSRFToken::_token()); ?>" value="Create">
                                                    </div>
                                                </div>
                                            </form>
                                            <a href="/admin/product/categories" class="close-button" aria-label="Close modal" type="button">
                                                <span aria-hidden="true">&times;</span>
                                            </a>
                                        </div>
                                        <!-- End Add Sub-Category Modal -->
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>

                    <!-- Display Pagination -->
                    <?php echo $links; ?>

                <?php else: ?>
                    <h3>You have not created any category</h3>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <!-- End Category Display -->

    <!-- Start SubCategory Display -->
    <div class="subcategory grid-container fluid">
        <div class="grid-x grid-margin-x">
            <div class="cell large-12">
                <h2>Sub Categories</h2>
                <hr>
            </div>
        </div>

        <div class="grid-x grid-margin-x">
            <div class="cell large-12 small-12 medium-12">
                <?php if(count($subcategories)): ?>
                    <table class="hover unstriped" data-form="deleteForm">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Date Created</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $subcategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subcategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($subcategory['name']); ?></td>
                                    <td><?php echo e($subcategory['slug']); ?></td>
                                    <td><?php echo e($subcategory['added']); ?></td>
                                    <td width="100" class="text-center">
                                        <span data-tooltip class="top" tabindex="2" title="Edit Subcategory">
                                           <a data-open="item-subcategory-<?php echo e($subcategory['id']); ?>"><i class="fa fa-edit"></i></a>
                                        </span>
                                        <span style="display: inline-block" data-tooltip class="top" tabindex="2" title="Delete Subcategory">
                                            <form action="/admin/product/subcategory/<?php echo e($subcategory['id']); ?>/delete" method="post" class="delete-item">
                                                <input type="hidden" name="token" value="<?php echo e(\App\Classes\CSRFToken::_token()); ?>">
                                                <button type="submit"><i class="fa fa-times delete"></i></button>
                                            </form>
                                        </span>

                                        <!-- Start Edit SubCategory Modal -->
                                        <div class="reveal" id="item-subcategory-<?php echo e($subcategory['id']); ?>" data-reveal data-close-on-click="false" data-close-on-esc="false" data-animation-in="scale-in-up">
                                            <div class="notification callout primary"></div>
                                            <h2>Edit Subcategory</h2>
                                            <form>
                                                <input type="text" id="item-subcategory-name-<?php echo e($subcategory['id']); ?>" value="<?php echo e($subcategory['name']); ?>">
                                                <label>
                                                    Change Category
                                                    <select name="" id="item-category-<?php echo e($subcategory['category_id']); ?>" id="">
                                                        <?php $__currentLoopData = \App\Models\Category::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php if($category->id == $subcategory['category_id']): ?>
                                                                <option selected="selected" value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>
                                                            <?php endif; ?>
                                                            <option value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </label>
                                                <div>
                                                    <input type="submit" class="button update-subcategory" id="<?php echo e($subcategory['id']); ?>" data-category-id="<?php echo e($subcategory['category_id']); ?>" data-token="<?php echo e(\App\Classes\CSRFToken::_token()); ?>" value="Update">
                                                </div>
                                            </form>
                                            <a href="/admin/product/categories" class="close-button" aria-label="Close modal" type="button">
                                                <span aria-hidden="true">&times;</span>
                                            </a>
                                        </div>
                                        <!-- End Edit SubCategory Modal -->
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>

                    <!-- Display Pagination -->
                    <?php echo $subcategories_links; ?>

                <?php else: ?>
                    <h3>You have not created any subcategory</h3>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <!-- End SubCategory Display -->

    <?php echo $__env->make('includes.delete-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/mazhar/www/practice/php/eTrade/resources/views/admin/products/categories.blade.php ENDPATH**/ ?>