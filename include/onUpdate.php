<?php
function xoops_module_update_tad_embed(&$module, $old_version)
{
    global $xoopsDB;

    if (chk_chk1()) {
        go_update1();
    }

    return true;
}

//�ˬd�Y���O�_�s�b
function chk_chk1()
{
    global $xoopsDB;
    $sql           = "select count(*) from " . $xoopsDB->prefix("tadtools_setup") . " where tt_theme='for_tad_embed_theme'";
    $result        = $xoopsDB->query($sql);
    list($counter) = $xoopsDB->fetchRow($result);
    if (empty($counter)) {
        return true;
    }

    return false;
}

//�����s
function go_update1()
{
    global $xoopsDB;
    $sql = "INSERT INTO " . $xoopsDB->prefix("tadtools_setup") . " (`tt_theme`, `tt_use_bootstrap`, `tt_bootstrap_color`, `tt_theme_kind`) VALUES ('for_tad_embed_theme', '0',  'bootstrap3', 'html'),";
    $xoopsDB->queryF($sql) or redirect_header(XOOPS_URL, 3, mysql_error());

    return true;
}

//�إߥؿ�
function mk_dir($dir = "")
{
    //�Y�L�ؿ��W�٨q�Xĵ�i�T��
    if (empty($dir)) {
        return;
    }

    //�Y�ؿ����s�b���ܫإߥؿ�
    if (!is_dir($dir)) {
        umask(000);
        //�Y�إߥ��Ѩq�Xĵ�i�T��
        mkdir($dir, 0777);
    }
}

//�����ؿ�
function full_copy($source = "", $target = "")
{
    if (is_dir($source)) {
        @mkdir($target);
        $d = dir($source);
        while (false !== ($entry = $d->read())) {
            if ($entry == '.' || $entry == '..') {
                continue;
            }

            $Entry = $source . '/' . $entry;
            if (is_dir($Entry)) {
                full_copy($Entry, $target . '/' . $entry);
                continue;
            }
            copy($Entry, $target . '/' . $entry);
        }
        $d->close();
    } else {
        copy($source, $target);
    }
}

function rename_win($oldfile, $newfile)
{
    if (!rename($oldfile, $newfile)) {
        if (copy($oldfile, $newfile)) {
            unlink($oldfile);
            return true;
        }
        return false;
    }
    return true;
}

function delete_directory($dirname)
{
    if (is_dir($dirname)) {
        $dir_handle = opendir($dirname);
    }

    if (!$dir_handle) {
        return false;
    }

    while ($file = readdir($dir_handle)) {
        if ($file != "." && $file != "..") {
            if (!is_dir($dirname . "/" . $file)) {
                unlink($dirname . "/" . $file);
            } else {
                delete_directory($dirname . '/' . $file);
            }

        }
    }
    closedir($dir_handle);
    rmdir($dirname);
    return true;
}
