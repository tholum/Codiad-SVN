<?php

    /*
    *  Copyright (c) Codiad & daeks & Coulee Techlink, distributed
    *  as-is and without warranty under the MIT License. See 
    *  [root]/license.txt for more. This information must remain intact.
    */

    require_once('../../common.php');
    
    //////////////////////////////////////////////////////////////////
    // Verify Session or Key
    //////////////////////////////////////////////////////////////////
    
    checkSession();

    switch($_GET['action']){
            
        //////////////////////////////////////////////////////////////////////
        // Pull Repo
        //////////////////////////////////////////////////////////////////////
        
        case 'pull':
            $newproject = $_GET['newproject'];
            
        
            ?>
            <form>
            <label>Folder Name</label>
            <input name="path" autofocus="autofocus" autocomplete="off">            
            <!-- Clone From svnHub -->
            <div style="width: 500px;">
            <table id="svn-clone">
                <tr>
                    <td>
                        <label>Svn Repository</label>
                        <input name="svn_repo">
                    </td>
                    <td width="5%">&nbsp;</td>
                    <td >
                        <label>Rev</label>
                        <input name="svn_branch" value="HEAD">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Create Project</label>
                        <input name="svn_newproject" type="checkbox" <?php if($newproject == 'yes'){ echo " CHECKED "; } ?> >
                    </td>
                    <td width="5%">&nbsp;</td>
                    <td >
                    <label>Project Name</label>
                        <input name="svn_projectname" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Username</label>
                        <input name="svn_username">
                    </td>
                    <td width="5%">&nbsp;</td>
                    <td width="47%">
                        <label>Password</label>
                        <input type="password" name="svn_password" value="">
                    </td>
                </tr>
                <tr>
                    <td colspan="3" class="note">If your Codaid install is not over https AND you are using a password, DO NOT USE THIS, Anyone with a packet sniffer will easly be able to get your username and password</td>
                </tr>
            </table>
            </div>
            <!-- /Clone From svnHub -->        
            <button class="btn-left">Execute</button><button class="btn-right" onclick="codiad.modal.unload();return false;">Cancel</button>
            <form>
            <?php
            break;
            
    }
    
?>
