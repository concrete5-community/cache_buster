<?php

defined('C5_EXECUTE') or die('Access Denied.');

use Concrete\Core\Support\Facade\Url;

/** @var \Concrete\Core\Validation\CSRF\Token $token */

/** @var string|null $lastBusted */
/** @var bool $enableCacheBuster */
/** @var bool $enableInDashboardArea */
/** @var bool $enableLogging */
/** @var string $cssInclude */
/** @var string $cssExclude */
/** @var string $javaScriptInclude */
/** @var string $javaScriptExclude */
?>

<div class="ccm-dashboard-header-buttons btn-group">
    <a
        data-placement="bottom"
        class="btn btn-default launch-tooltip"
        title="<?php echo t("This will create a new hash. The hash will be used in the CSS / JS file names. PS. It's totally safe."); ?>"
        href="<?php echo $this->action('bust') ?>">
        <?php echo t('Bust the CSS/JS cache!'); ?>
    </a>
</div>

<div class="ccm-dashboard-content-inner">
    <form method="post" action="<?php echo $this->action('save'); ?>">
        <?php
        echo $token->output('a3020.cache_buster.settings');
        ?>

        <?php
        if ($lastBusted) {
            echo '<p class="text-muted">' . t('The cache was last busted on %s', $lastBusted);
        }
        ?>

        <h3><?php echo t('Basic settings'); ?></h3>
        <div class="form-group">
            <label class="control-label launch-tooltip"
                   title="<?php echo t("If disabled, the HTML output will not be altered. You'd also disable it, if you manually add the 'hash' to your theme's CSS/JS file(s).") ?>"
                   for="enableCacheBuster">
                <?php
                echo $form->checkbox('enableCacheBuster', 1, $enableCacheBuster);
                ?>
                <?php echo t('Enable %s', t('Cache Buster')); ?>
            </label>
        </div>

        <div class="form-group">
            <label class="control-label launch-tooltip"
                   title="<?php echo t("Disable if you don't want to 'cache bust' assets in the dashboard area.") ?>"
                   for="enableInDashboardArea">
                <?php
                echo $form->checkbox('enableInDashboardArea', 1, $enableInDashboardArea);
                ?>
                <?php echo t('Enable in dashboard area'); ?>
            </label>
        </div>

        <div class="form-group">
            <label class="control-label launch-tooltip"
                   title="<?php echo t("This will add a start and end time to the log, to see how much it affects performance.") ?>"
                   for="enableLogging">
                <?php
                echo $form->checkbox('enableLogging', 1, $enableLogging);
                ?>
                <?php echo t('Enable logging'); ?>
            </label><br>
            <small class="help-block"><?php echo t('Please disable this in production.'); ?></small>
        </div>

        <h3><?php echo t('Advanced settings'); ?></h3>

        <p class="help-block">
            <?php
            echo t('To match paths, the PHP %s function is used. That means you can use * and ? characters, for example.',
                '<a href="https://secure.php.net/manual/en/function.fnmatch.php" target="_blank">' . t('fnmatch') . '</a>'
            );
            ?>
            <?php
            echo t('Please visit %s if you want to test different matching patterns.',
                '<a href="http://www.globtester.com" target="_blank">http://www.globtester.com</a>'
            );
            ?>
        </p>

        <div class="form-group">
            <label class="control-label launch-tooltip"
                   title="<?php echo t('If a path is matched here, it will always contain the cache buster.') ?>"
                   for="cssInclude">
                <?php echo t('CSS include paths'); ?>
            </label>
            <?php
            echo $form->textarea('cssInclude', $cssInclude, [
                'rows' => 4,
                'placeholder' => t('Use one path per line'),
            ]);
            ?>
        </div>

        <div class="form-group">
            <label class="control-label launch-tooltip"
                   title="<?php echo t('If the path is not included specifically, and it matches the exclude rule, it will never contain the cache buster.') ?>"
                   for="cssExclude">
                <?php echo t('CSS exclude paths'); ?>
            </label>
            <?php
            echo $form->textarea('cssExclude', $cssExclude, [
                'rows' => 4,
                'placeholder' => t('Use one path per line'),
            ]);
            ?>
            <span class="help-block"><?php echo t("E.g. %s to exclude core CSS files.", '/concrete/css/*') ?></span>
        </div>

        <div class="form-group">
            <label class="control-label launch-tooltip"
                   title="<?php echo t('If a path is matched here, it will always contain the cache buster.') ?>"
                   for="javaScriptInclude">
                <?php echo t('JavaScript include paths'); ?>
            </label>
            <?php
            echo $form->textarea('javaScriptInclude', $javaScriptInclude, [
                'rows' => 4,
                'placeholder' => t('Use one path per line'),
            ]);
            ?>
        </div>

        <div class="form-group">
            <label class="control-label launch-tooltip"
                   title="<?php echo t('If the path is not included specifically, and it matches the exclude rule, it will never contain the cache buster.') ?>"
                   for="javaScriptExclude">
                <?php echo t('JavaScript exclude paths'); ?>
            </label>
            <?php
            echo $form->textarea('javaScriptExclude', $javaScriptExclude, [
                'rows' => 4,
                'placeholder' => t('Use one path per line'),
            ]);
            ?>
            <span class="help-block"><?php echo t("E.g. %s to exclude core JavaScript files.", '/concrete/js/*') ?></span>
        </div>

        <div class="ccm-dashboard-form-actions-wrapper">
            <div class="ccm-dashboard-form-actions">
                <button class="pull-right btn btn-primary" type="submit">
                    <?php echo t('Save') ?>
                </button>
            </div>
        </div>
    </form>
</div>

<script>
$(document).ready(function(){
    $('#regenerateHash').change(function() {
        $('#hash').toggle($(this).attr('checked'));
    })
})
</script>
