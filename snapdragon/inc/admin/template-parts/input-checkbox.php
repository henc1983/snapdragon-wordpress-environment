<section class="grid grid-cols-12 mb-6">    
    <div class="grid grid-cols-12 col-span-12">
        <label class="input-group-label" for="snapdragon-checkbox-<?php esc_attr_e( $args['id'] ) ?>">
            <?php esc_html_e( $args['title'] ) ?>
        </label>
        <div class="col-span-7 self-center toggle-button-group group">
            <label for="snapdragon-checkbox-<?php esc_attr_e( $args['id'] ) ?>" >
                <span class="thumb"></span>
                <input type="checkbox" name="<?php esc_attr_e( $args['id'] ) ?>" id="snapdragon-checkbox-<?php esc_attr_e( $args['id'] ) ?>" value="Y" <?php esc_attr_e( ! ( get_theme_mod( $args['id'] ) === 'Y' ) ? '' : 'checked' ) ?>>
            </label>
        </div>
    </div>
    <div class="col-span-5 mt-2"><?php esc_html_e( $args['desc'] ) ?></div>
    <div class="col-span-7"></div>
    <hr class="my-4 h-0.5 border-t-0 bg-neutral-50 col-span-6" />
</section>