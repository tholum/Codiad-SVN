<?php

    /*
    *  Copyright (c) Codiad & daeks & Coulee Techlink, distributed
    *  as-is and without warranty under the MIT License. See
    *  [root]/license.txt for more. This information must remain intact.
    */


    require_once('../../common.php');
    require_once('class.svn.php');

    //////////////////////////////////////////////////////////////////
    // Verify Session or Key
    //////////////////////////////////////////////////////////////////

    checkSession();

    $svn = new svn();

    //////////////////////////////////////////////////////////////////
    // Pull Repo
    //////////////////////////////////////////////////////////////////

    if($_GET['action']=='pull'){
        $svn->path = $_GET['path'];
        $svn->name = $_GET['svn_projectname'];
        $svn->svnrepo = $_GET['svn_repo'];
        $svn->svnbranch = $_GET['svn_branch'];
        $svn->username = $_GET['svn_username'];
        $svn->password = $_GET['svn_password'];
        $svn->newproject = $_GET['svn_newproject'];
        $svn->Pull();
    }
   
?>