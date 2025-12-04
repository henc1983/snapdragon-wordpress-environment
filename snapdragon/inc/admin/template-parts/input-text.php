<section class="grid grid-cols-12">
    <div class="grid grid-cols-12 col-span-12">
        <label class="input-group-label" for="<?php esc_attr_e( $args[ 'id' ] ) ?>">
            <?php esc_html_e( $args[ 'title' ] ) ?>
        </label>
        <div class="col-span-7">
            <input class="min-w-3xs" type="text" name="<?php esc_attr_e( $args[ 'id' ] ) ?>" id="<?php esc_attr_e( $args[ 'id' ] ) ?>" value="<?php echo get_theme_mod( $args['id'] ) ?>">
        </div>
    </div>
    
    <?php if( isset( $args[ 'desc' ] ) ) : ?>
        <p class="col-span-5 pe-6"><?php esc_html_e( $args[ 'desc' ] ) ?></p>
        <p class="col-span-7"></p>
    <?php endif; ?>

    <hr class="my-4 h-0.5 border-t-0 bg-neutral-50 col-span-12" />
</section>