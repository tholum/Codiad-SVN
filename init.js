/*
 *  Copyright (c) Codiad & daeks & Coulee Techlink, distributed
 *  as-is and without warranty under the MIT License. See
 *  [root]/license.txt for more. This information must remain intact.
 */

(function(global, $){

    var codiad = global.codiad,
        scripts = document.getElementsByTagName('script'),
        path = scripts[scripts.length-1].src.split('?')[0],
        curpath = path.split('/').slice(0, -1).join('/')+'/';

    $(function() {
        codiad.svn.init();
    });

    codiad.svn = {
        
        controller: curpath + 'controller.php',
        dialog: curpath + 'dialog.php',

        init: function() {
            $('.project-list-title').append('<a id="project-svn" class="icon-publish icon" ></a>');
            $('#project-svn').click(codiad.svn.create_project);
        },
        create_project: function(){
            codiad.svn.pull('yes');
        },
        pull: function(newproject) {
            var _this = this;
            codiad.modal.load(550, _this.dialog + '?action=pull&newproject=' + newproject );
            $('#modal-content form')
                .live('submit', function(e) {
                e.preventDefault();
                if(  $('#modal-content form input[name="svn_newproject"]').is(':checked')){
                        svn_newproject = true;
                        var path =  $('#modal-content form input[name="path"]').val();
                    } else {
                        svn_newproject = false;   
                        var path = root + '/' + $('#modal-content form input[name="path"]').val();
                    }
                var root = codiad.project.getCurrent(),
                    svnRepo = $('#modal-content form input[name="svn_repo"]')
                    .val(),
                    svnBranch = $('#modal-content form input[name="svn_branch"]')
                    .val();
                    svnBranch = $('#modal-content form input[name="svn_username"]')
                    .val();
                    svnPassword = $('#modal-content form input[name="svn_password"]')
                    .val();
                    svn_projectname = $('#modal-content form input[name="svn_projectname"]').val();
                    $('#modal-content').html('<div id="modal-loading"></div><div align="center">Contacting SVN Server...</div><br>');
                    $.get(_this.controller + '?' + $.param({ 'svn_projectname': svn_projectname , 'svn_newproject': svn_newproject ,action: 'pull', path: path, 'svn_repo':svnRepo, svn_branch:svnBranch,  svn_username: svnBranch,svn_password:svnPassword })  , function(data) {
                        createResponse = codiad.jsend.parse(data);
                        if (createResponse != 'error') {
                            codiad.message.success(createResponse.message);
                            codiad.filemanager.rescan(root);
                        } else {
                            codiad.message.error(createResponse.message);
                        }
                        codiad.modal.unload();
                    });
            });
        },
                
        open: function(path) {
        }
        
    };

})(this, jQuery);
