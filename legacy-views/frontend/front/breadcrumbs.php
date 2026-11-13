<div class="breadcrumbs">
   <div class="container">
      <div class="row">
         <div class="col-xs-12">
            <ul>
               <?php
                  $requestPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
                  $basePath = rtrim((string) parse_url(base_url(), PHP_URL_PATH), '/');

                  if ($basePath !== '' && ($requestPath === $basePath || str_starts_with($requestPath, $basePath . '/'))) {
                     $requestPath = substr($requestPath, strlen($basePath));
                  }

                  $breadcrumbs = array_values(array_filter(explode('/', trim($requestPath, '/'))));
                  $categories = $this->CategoryModel->get_all_category_front();
                  $parentCategoryId = 0;
                  $breadcrumbPath = '';
                  $pageTitle = $GLOBALS['page_title'] ?? '';
               ?>
               <div class="breadcrumb-container">
                  <div class="container">
                     <ol class="breadcrumb">
                        <li><i class="fa fa-home"></i><a href="<?php echo esc(base_url()); ?>" title="Home Page"><span><?php echo esc('Home'); ?></span></a></li>
                        <?php foreach ($breadcrumbs as $crumb) {
                           $crumb = rawurldecode($crumb);
                           $category = null;

                           foreach ($categories as $candidate) {
                              if ((string) $candidate->category_url_name === $crumb
                                 && (int) $candidate->parent_id === $parentCategoryId) {
                                 $category = $candidate;
                                 break;
                              }
                           }

                           if ($category !== null) {
                              $label = $category->category_name;
                              $parentCategoryId = (int) $category->category_id;
                           } else {
                              $label = ucwords(str_replace(['.php', '-', '_'], ['', ' ', ' '], $crumb));
                              $parentCategoryId = 0;
                           }

                           $breadcrumbPath .= ($breadcrumbPath === '' ? '' : '/') . rawurlencode($crumb);
                           ?>
                        <li><a href="<?php echo esc(base_url($breadcrumbPath)); ?>" title="<?php echo esc((string) $pageTitle); ?>"><span><?php echo esc($label); ?></span></a></li>
                        <?php } ?>
                     </ol>
                  </div>
               </div>
            </ul>
         </div>
      </div>
   </div>
</div>