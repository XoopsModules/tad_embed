<?php
defined('XOOPS_ROOT_PATH') or die('Restricted access');

/**
 * Class to allow <{if $homepage}>Your code here<{/if}> in templates
 * @author trabis
 */
class Tad_EmbedCorePreload extends XoopsPreloadItem
{
    public static function eventCoreHeaderStart($args)
    {
        // die($_SERVER['PHP_SELF']);
        if (strpos($_SERVER['PHP_SELF'], "tad_embed_demo.php") !== false) {
            $GLOBALS['xoopsConfig']['theme_set_allowed'][] = "for_tad_embed_theme";
            $_POST['xoops_theme_select']                   = "for_tad_embed_theme";
        } else {
            $_POST['xoops_theme_select'] = $GLOBALS['xoopsConfig']['theme_set'];
        }
    }
}
