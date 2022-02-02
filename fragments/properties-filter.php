<div class="widget-body">

    <div class="form">
        <form action="<?php echo get_permalink(get_the_ID()); ?>" method="GET">

            <?php
            $links = array(
                'crb_search_page' => 'Продажби',
                'crb_search_page_rentals' => 'Наеми',
            );
            ?>

            <div class="form-head">
                <div class="form-nav clearfix">
                    <ul>

                        <?php foreach ($links as $key => $label):
                            $link_id = get_option( $key );

                            $active = '';
                            if ( $link_id == get_the_ID() ) {
                                $active = 'class="active"';
                            }

                            $url = get_permalink( $link_id );

                            if ( count($_GET) > 1 ) {
                                $url = add_query_arg($_GET, $url);
                            }
                            ?>

                            <li>
                                <a <?php echo $active; ?> href="<?php echo $url; ?>">
                                    <?php echo $label; ?>
                                </a>
                            </li>

                        <?php endforeach ?>

                    </ul>
                </div><!-- /.form-nav -->
            </div><!-- /.form-head -->

            <div class="form-body">

                <div class="form-row">
                    <label for="field-place" class="form-label">Населено място</label>

                    <div class="form-controls">
                        <?php crb_property_main_areas(); ?>
                    </div><!-- /.form-controls -->
                </div><!-- /.form-row -->

                <div class="form-row">
                    <label for="field-place" class="form-label">Местоположение</label>
                    <?php crb_dd_filter( 'Райони', 'crb_property_areas', 'property-area' ); ?>
                </div><!-- /.form-row -->

                <div class="form-row">
                    <label for="field-place" class="form-label">Вид на имота</label>
                    <?php crb_dd_filter( 'Всички', 'crb_render_type_filter', 'property-type' ); ?>
                </div><!-- /.form-row -->

                <div class="form-row">
                    <label for="field-place" class="form-label">Квадратура</label>
                    <?php crb_slider_sqf(); ?>
                </div><!-- /.form-row -->

                <div class="form-row">
                    <label for="field-place" class="form-label">Цена</label>
                    <?php crb_slider_price(); ?>
                </div><!-- /.form-row -->

                <div class="form-row">
                    <label for="field-place" class="form-label">Цена на кв.м</label>
                    <?php crb_slider_sqf_price(); ?>
                </div><!-- /.form-row -->

                <div class="form-row">
                    <label for="field-place" class="form-label">Вид строителство</label>
                    <div class="form-controls">
                        <?php crb_building_type_filter(); ?>
                    </div><!-- /.form-controls -->
                </div><!-- /.form-row -->

                <div class="form-row">
                    <label for="field-place" class="form-label">Изложение</label>
                    <div class="form-controls">
                        <?php crb_building_position_filter(); ?>
                    </div><!-- /.form-controls -->
                </div><!-- /.form-row -->

                <div class="form-row">
                    <label for="field-place" class="form-label">Година на построяване</label>
                    <div class="form-controls">
                        <?php crb_property_years(); ?>
                    </div><!-- /.form-controls -->
                </div><!-- /.form-row -->

                <div class="form-row">
                    <label for="field-place" class="form-label">Допълнителни критерии</label>
                    <?php crb_dd_filter( 'Критерии', 'crb_extra_criteria', 'criteria' ); ?>
                </div><!-- /.form-row -->

                <?php if (isset($_GET['predefined']) AND (int) $_GET['predefined'] !== 1) : ?>
                    <div class="form-row">
                        <label for="field-place" class="form-label">Сортиране по</label>
                        <div class="form-controls">
                            <?php crb_sorting_options(); ?>
                        </div><!-- /.form-controls -->
                    </div><!-- /.form-row -->

                    <div class="form-row">
                        <label for="field-place" class="form-label">Приоритет</label>
                        <div class="form-controls">
                            <?php crb_priorities_filter(); ?>
                        </div><!-- /.form-controls -->
                    </div><!-- /.form-row -->
                <?php endif; ?>

                <div class="form-row">
                    <label for="field-place" class="form-label">Референтен номер</label>
                    <div class="form-controls">
                        <input type="text" name="ref-number" value="<?php echo (isset($_GET['ref-number']) ? $_GET['ref-number'] : ''); ?>" />
                    </div><!-- /.form-controls -->
                </div><!-- /.form-row -->

            </div><!-- /.form-body -->

            <div class="form-actions">
                <input type="submit" class="form-btn" value="Търси" />
            </div><!-- /.form-actions -->
        </form>
    </div><!-- /.form -->
</div>