/*------------------
    crud
--------------------*/

jQuery(document).ready(function($) {
        /************************
         *      商品CRUD        *
         ************************/
        //查詢
        var game_tbl = $('#game_datatable').DataTable({
            scrollCollapse: true,
            autoWidth: false,
            responsive: true,
            "ajax": {
                url: "crud.php",
                data: function(d) {
                      return $('#edit-game-form').serialize() + "&oper=query";
                },
                type: 'POST',
                dataType: 'json'
            },
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "language": {
                "processing": "處理中...",
                "loadingRecords": "載入中...",
                "lengthMenu": "顯示 _MENU_ 項結果",
                "zeroRecords": "沒有符合的結果",
                "info": "顯示第 _START_ 至 _END_ 項結果，共 _TOTAL_ 項",
                "infoEmpty": "顯示第 0 至 0 項結果，共 0 項",
                "infoFiltered": "(從 _MAX_ 項結果中過濾)",
                "infoPostFix": "",
                "search": "搜尋:",
                "paginate": {
                    "first": "第一頁",
                    "previous": "上一頁",
                    "next": "下一頁",
                    "last": "最後一頁"
                }    
            }
        });
        //新增
        $('tbody').on('click', '#game_insert', function() {
            $("#tableType").val("gameTable");
            $("#oper").val("insert");
        });        
        //修改
        $('tbody').on('click', '#game_update', function() {
            $("#tableType").val("gameTable");
            var data = game_tbl.row(this).data();
            var imageID = $('#datatable-img'+data[1]);
            $("#image").attr("src", imageID.attr("src")); 
            $('#edit-game_ID').val(data[1]);     
            $('#edit-game-name').val(data[2]);
            $('#edit-game-date').val(data[3]);
            let language = data[4].split('/');
            for(var i=0;i<language.length;i++){
                if(language[i] == "繁體中文")
                    $('input[name="game_lang[]"][value=1]').prop('checked', true);
                else if(language[i] == "英文")
                    $('input[name="game_lang[]"][value=2]').prop('checked', true);
                else if(language[i] == "日文")
                    $('input[name="game_lang[]"][value=3]').prop('checked', true);
                }
            if (data[5] == "普通級")
                $('input[name="game_rated"][value=G]').prop('checked', true);
            else if(data[5] == "保護級")
                $('input[name="game_rated"][value=PG]').prop('checked', true);
            else if(data[5] == "輔導級")
                $('input[name="game_rated"][value=PG-13]').prop('checked', true);
            else if(data[5] == "限制級")
                $('input[name="game_rated"][value=R]').prop('checked', true);

           $('#edit-game-price').val(data[6]);
           let discount = data[7].split('%');
           $("#edit-game-discount").val(discount[0]);
           $("#edit-game-developer").val(data[9]);
           $("#edit-game-publisher").val(data[10]);
           let categories = data[11].split('/');
            for(var i=0;i<categories.length;i++){
                if(categories[i] == "休閒")
                    $('input[name="game_cate[]"][value=1]').prop('checked', true);
                else if(categories[i] == "冒險")
                    $('input[name="game_cate[]"][value=2]').prop('checked', true);
                else if(categories[i] == "動作")
                    $('input[name="game_cate[]"][value=3]').prop('checked', true);
                else if(categories[i] == "策略")
                    $('input[name="game_cate[]"][value=4]').prop('checked', true);
                else if(categories[i] == "卡牌")
                    $('input[name="game_cate[]"][value=5]').prop('checked', true);
                else if(categories[i] == "汽機車模擬")
                    $('input[name="game_cate[]"][value=6]').prop('checked', true);
                else if(categories[i] == "恐怖")
                    $('input[name="game_cate[]"][value=7]').prop('checked', true);
                else if(categories[i] == "第一人稱")
                    $('input[name="game_cate[]"][value=8]').prop('checked', true);
                else if(categories[i] == "單人")
                    $('input[name="game_cate[]"][value=9]').prop('checked', true);
                else if(categories[i] == "多人")
                    $('input[name="game_cate[]"][value=10]').prop('checked', true);
            }

           $("#edit-game-story").val(data[12]);
           $("#oper").val("update");
        });

       //取消
       $('#game_cancel').on('click', function () {
            $("#oper").val("insert");
            $("#edit-game-form").get(0).reset();
            game_validator.resetForm();
            $('.edit-model').fadeOut(400);
        });

       //刪除
       $('tbody').on('click', '#game_delete', function() {
          var data = game_tbl.row(this).data();
          if (!confirm('是否確定要刪除?'))
                return false;
            $("#tableType").val("gameTable");
            $("#edit-game_ID").val(data[1]);
            $("#oper").val("delete"); //刪除
            game_CRUD();
       });  

       //送出表單 (儲存)

       var game_validator = $("#edit-game-form").validate({
          submitHandler: function(form) {
                $('.edit-model').fadeOut(400);
                game_CRUD();          
          },
          rules: {
                "edit-game-name": {
                    required: true
                },
                "edit-game-date": {
                    required: true
                },
                "game_cate[]": {
                    required: true
                },
                game_rated: {
                    required: true
                },
                "edit-game-price": {
                    required: true
                },
                "edit-game-discount": {
                    required: true
                },
                "edit-game-developer": {
                    required: true
                },
                "edit-game-publisher": {
                    required: true
                },
                "edit-game-story": {
                    required: true
                }
            }
        });

        function game_CRUD() {
            $.ajax({
                url: "crud.php",
                data: $("#edit-game-form").serialize(),
                type: 'POST',
                dataType: "json",
                success: function(JData) {                 
                    $("#edit-game-form").get(0).reset();
                    game_validator.resetForm();
                      if (JData.code){
                            toastr.error(JData.message);
                            console.log(JData.message);
                      }
                      else {
                            $("#oper").val("insert");
                            game_tbl.ajax.reload();   
                            toastr.success(JData.message);
                      }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    $("#edit-game-form").get(0).reset();
                    game_validator.resetForm();
                    console.log(xhr.responseText);
                    alert(xhr.responseText);
                }
            });
        }

        /************************
         *      會員CRUD        *
         ************************/
        //查詢
        var member_tbl = $('#member_datatable').DataTable({
            scrollCollapse: true,
            autoWidth: false,
            responsive: true,
            "ajax": {
                url: "crud.php",
                data: function(d) {
                      return $('#edit-member-form').serialize() + "&oper=query";
                },
                type: 'POST',
                dataType: 'json'
            },
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "language": {
                "processing": "處理中...",
                "loadingRecords": "載入中...",
                "lengthMenu": "顯示 _MENU_ 項結果",
                "zeroRecords": "沒有符合的結果",
                "info": "顯示第 _START_ 至 _END_ 項結果，共 _TOTAL_ 項",
                "infoEmpty": "顯示第 0 至 0 項結果，共 0 項",
                "infoFiltered": "(從 _MAX_ 項結果中過濾)",
                "infoPostFix": "",
                "search": "搜尋:",
                "paginate": {
                    "first": "第一頁",
                    "previous": "上一頁",
                    "next": "下一頁",
                    "last": "最後一頁"
                }    
            }
        });
        //新增
        $('tbody').on('click', '#member_insert', function() {
            $("#tableType").val("memberTable");
            $("#oper").val("insert");
        });        
        //修改
        $('tbody').on('click', '#member_update', function() {
            var data = member_tbl.row(this).data();
            $('#edit-member-account').val(data[0]);     
            $('#edit-member-email').val(data[1]);
            if(data[4] == '黃金會員')
                $('#edit-member-level').val(1);
            else if(data[4] == '白金會員')
                $('#edit-member-level').val(2);
            else if(data[4] == '鑽石會員')
                $('#edit-member-level').val(3);
            $('#edit-member-name').val(data[2]);
            $('#edit-member-nickname').val(data[3]);
             if (data[5] == "男性")
                $('input[name="edit-member-sex"][value=M]').prop('checked', true);
            else if(data[5] == "女性")
                $('input[name="edit-member-sex"][value=F]').prop('checked', true);
            $('#edit-member-birth').val(data[7]);
            $('#edit-member-phone').val(data[6]);

            $("#tableType").val("memberTable");
            $('#old-member_account').val(data[0]);
            $("#oper").val("update");

            if($("#oper").val() == "update"){
                $("#edit-member-account").prop('readonly', true);
            }
        });

       //取消
       $('#member_cancel').on('click', function () {         
            $("#oper").val("insert");
            $("#edit-member-form").get(0).reset();
            formData.delete('account');
            $('#account_check').text('');
            member_validator.resetForm();  
            $("#edit-member-account").prop('readonly', false);
            $('.edit-model').fadeOut(400);
        });

       //刪除
       $('tbody').on('click', '#member_delete', function() {
          var data = member_tbl.row(this).data();
          if (!confirm('是否確定要刪除?'))
                return false;
            $("#tableType").val("memberTable");
            $("#old-member_account").val(data[0]);
            $("#oper").val("delete"); //刪除
            member_CRUD();
       });  

       //送出表單 (儲存)
       jQuery.validator.methods.matches = function( value, element, params ) {
            var re = new RegExp(params);
            return this.optional( element ) || re.test( value );
        }

        $.validator.addMethod("pwd",function(value,element,params){
            var pwd = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,20}$/;
            return (pwd.test(value));
        },"請填寫長度在8-20之間,需包含一個字母和一個數字!");

        var formData = new FormData();
        $('#edit-member-account').keyup(function() {
            if($("#oper").val() == 'insert'){
                formData.set('account', $('#edit-member-account').val());
                $.ajax({
                    url: "function.php?op=signupCheckAjax",
                    data: formData,
                    type: "POST",
                    dataType: 'text',
                    processData: false,
                    contentType: false,
                    success: function(msg) {
                        $('#account_check').text(msg); 
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.status);
                        alert(thrownError);
                    }
                });
            }    
        });
        
        var member_validator = $("#edit-member-form").validate({
          submitHandler: function() {
                if($("#oper").val() == 'insert'){
                    formData.set('account', $('#edit-member-account').val());
                    $.ajax({
                        url: "function.php?op=signupCheckAjax",
                        data: formData,
                        type: "POST",
                        dataType: 'text',
                        processData: false,
                        contentType: false,
                        success: function(msg) {
                            $('#account_check').text(msg); 
                            if(msg != "此帳號已存在!")
                            {
                                $('.edit-model').fadeOut(400);
                                member_CRUD();
                            }
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            alert(xhr.status);
                            alert(thrownError);
                        }
                    }); 
                } 
                else{
                    $('.edit-model').fadeOut(400);
                    member_CRUD();
                }         
          },
          rules: {
                "edit-member-account": {
                    required: true,
                    minlength: 4,
                    maxlength: 24
                },
                "edit-member-email": {
                    required: true,
                    email: true
                },
                "edit-member-password": {
                    required: {
                        depends: function(element) {
                            if ($("#oper").val() == 'insert') {
                                return true;
                            } else {
                                return false;
                            }
                        }
                    },
                    pwd: {
                        depends: function(element) {
                            if ($("#oper").val() == 'insert') {
                                return true;
                            } else {
                                return false;
                            }
                        }
                    }
                },
                "edit-member-pwd": {
                    required: {
                        depends: function(element) {
                            if ($("#oper").val() == 'insert') {
                                return true;
                            } else {
                                return false;
                            }
                        }
                    },
                    equalTo: {
                        param: '#edit-member-password',
                        depends: function(element) { 
                            return $("#oper").val() == 'insert'; 
                        }
                    }
                },
                "edit-member-level": {
                    required: true,
                    range:[1,3]
                },
                "edit-member-name": {
                    required: true
                },
                "edit-member-nickname": {
                    required: true
                },
                "edit-member-sex": {
                    required: true
                },
                "edit-member-birth": {
                    required: true,
                    dateISO:true
                },
                "edit-member-phone": {
                    required: true,
                    matches: new RegExp('^09\\d{8}$')
                }
            },
            messages: {
                "edit-member-account":{
                    required: "請輸入帳號",
                    minlength: "請輸入4到24位英數字組合",
                    maxlength: "請輸入4到24位英數字組合"
                },
                "edit-member-email": {
                    required: "請輸入電子郵箱",
                    email: "請輸入正確郵箱格式"
                },
                "edit-member-password": {
                    required: "請輸入密碼"
                },
                "edit-member-pwd": {
                    required: "請輸入確認密碼",
                    equalTo: "密碼不相符"
                },
                "edit-member-level": {
                    required: "請輸入會員層級(1-黃金會員|2-白金會員|3-鑽石會員)",
                    range: "請輸入介於1至3的會員層級"
                },
                "edit-member-name": {
                    required: "請輸入會員姓名"
                },
                "edit-member-nickname": {
                    required: "請輸入會員暱稱"
                },
                "edit-member-sex": {
                    required: "請輸入會員性別"
                },
                "edit-member-birth": {
                    required: "請輸入會員生日日期",
                    dateISO: "請輸入正確日期格式"
                },
                "edit-member-phone": {
                    required: "請輸入電話號碼",
                    matches: "請輸入正確的10位手機格式"
                }
            }
        });

        function member_CRUD() {
            $.ajax({
                url: "crud.php",
                data: $("#edit-member-form").serialize(),
                type: 'POST',
                dataType: "json",
                success: function(JData) {                 
                    $("#edit-member-form").get(0).reset();
                    member_validator.resetForm();
                    $("#edit-member-account").prop('readonly', false);
                      if (JData.code){
                            toastr.error(JData.message);
                            console.log(JData.message);
                      }
                      else {
                            $("#oper").val("insert");
                            member_tbl.ajax.reload();   
                            toastr.success(JData.message);    
                      }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    $("#edit-member-form").get(0).reset();
                    member_validator.resetForm();
                    $("#edit-member-account").prop('readonly', false);
                    console.log(xhr.responseText);
                    alert(xhr.responseText);
                }
            });
        }

        /************************
         *   交易紀錄CRUD        *
         ************************/
        //查詢
        var deal_tbl = $('#deal_datatable').DataTable({
            scrollCollapse: true,
            autoWidth: false,
            responsive: true,
            "ajax": {
                url: "crud.php",
                data: function(d) {
                      return $('#delete-deal-form').serialize() + "&oper=query";
                },
                type: 'POST',
                dataType: 'json'
            },
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "language": {
                "processing": "處理中...",
                "loadingRecords": "載入中...",
                "lengthMenu": "顯示 _MENU_ 項結果",
                "zeroRecords": "沒有符合的結果",
                "info": "顯示第 _START_ 至 _END_ 項結果，共 _TOTAL_ 項",
                "infoEmpty": "顯示第 0 至 0 項結果，共 0 項",
                "infoFiltered": "(從 _MAX_ 項結果中過濾)",
                "infoPostFix": "",
                "search": "搜尋:",
                "paginate": {
                    "first": "第一頁",
                    "previous": "上一頁",
                    "next": "下一頁",
                    "last": "最後一頁"
                }    
            }
        });

        //刪除
        $('tbody').on('click', '#deal_delete', function() {
          var data = deal_tbl.row($(this).closest('tr')).data();
          if (!confirm('是否確定要刪除?'))
                return false;
            $("#tableType").val("dealTable");
            $("#oper").val("delete");
            $("#deal_member_account").val(data[0]); 
            $("#deal_game_ID").val(data[1]);
            $("#deal_game_name").val(data[2]);
            $("#deal_price").val(data[3]);
            $("#deal_score").val(data[4]);
            $("#deal_datetime").val(data[5]);  
            deal_CRUD();
       }); 

        function deal_CRUD() {
            $.ajax({
                url: "crud.php",
                data: $("#delete-deal-form").serialize(),
                type: 'POST',
                dataType: "json",
                success: function(JData) {                 
                      if (JData.code){
                            toastr.error(JData.message);
                            console.log(JData.message);
                      }
                      else {
                            $("#oper").val("delete");
                            deal_tbl.ajax.reload();   
                            toastr.success(JData.message);
                      }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    console.log(xhr.responseText);
                    alert(xhr.responseText);
                }
            });
        }

        /************************
         *      管理員CRUD        *
         ************************/
        //查詢
        var admin_tbl = $('#admin_datatable').DataTable({
            scrollCollapse: true,
            autoWidth: false,
            responsive: true,
            "ajax": {
                url: "crud.php",
                data: function(d) {
                      return $('#edit-admin-form').serialize() + "&oper=query";
                },
                type: 'POST',
                dataType: 'json'
            },
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "language": {
                "processing": "處理中...",
                "loadingRecords": "載入中...",
                "lengthMenu": "顯示 _MENU_ 項結果",
                "zeroRecords": "沒有符合的結果",
                "info": "顯示第 _START_ 至 _END_ 項結果，共 _TOTAL_ 項",
                "infoEmpty": "顯示第 0 至 0 項結果，共 0 項",
                "infoFiltered": "(從 _MAX_ 項結果中過濾)",
                "infoPostFix": "",
                "search": "搜尋:",
                "paginate": {
                    "first": "第一頁",
                    "previous": "上一頁",
                    "next": "下一頁",
                    "last": "最後一頁"
                }    
            }
        });
        //新增
        $('tbody').on('click', '#admin_insert', function() {
            $("#tableType").val("adminTable");
            $("#oper").val("insert");
        });        
        //修改
        $('tbody').on('click', '#admin_update', function() {
            var data = admin_tbl.row(this).data();
            $('#edit-admin-account').val(data[0]);     
            $('#edit-admin-email').val(data[1]);
            $('#edit-admin-name').val(data[2]);
            $('#edit-admin-phone').val(data[3]);
            $("#tableType").val("adminTable");
            $('#old-admin_account').val(data[0]);
            $("#oper").val("update");
            if($("#oper").val() == "update"){
                $("#edit-admin-account").prop('readonly', true);
            }
        });

       //取消
       $('#admin_cancel').on('click', function () {         
            $("#oper").val("insert");
            $("#edit-admin-form").get(0).reset();
            formData.delete('account');
            $('#account_check').text('');
            admin_validator.resetForm();  
            $("#edit-admin-account").prop('readonly', false);
            $('.edit-model').fadeOut(400);
        });

       //刪除
       $('tbody').on('click', '#admin_delete', function() {
          var data = admin_tbl.row(this).data();
          if (!confirm('是否確定要刪除?'))
                return false;
            $("#tableType").val("adminTable");
            $("#old-admin_account").val(data[0]);
            $("#oper").val("delete"); //刪除
            admin_CRUD();
       });  

       //送出表單 (儲存)
       jQuery.validator.methods.matches = function( value, element, params ) {
            var re = new RegExp(params);
            return this.optional( element ) || re.test( value );
        }

        $.validator.addMethod("pwd",function(value,element,params){
            var pwd = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,20}$/;
            return (pwd.test(value));
        },"請填寫長度在8-20之間,需包含一個字母和一個數字!");

        var formData = new FormData();
        $('#edit-admin-account').keyup(function() {
            if($("#oper").val() == 'insert'){
                formData.set('account', $('#edit-admin-account').val());
                $.ajax({
                    url: "function.php?op=signupCheckAjax",
                    data: formData,
                    type: "POST",
                    dataType: 'text',
                    processData: false,
                    contentType: false,
                    success: function(msg) {
                        $('#account_check').text(msg); 
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.status);
                        alert(thrownError);
                    }
                });
            }    
        });
        
        var admin_validator = $("#edit-admin-form").validate({
          submitHandler: function() {
                if($("#oper").val() == 'insert'){
                    formData.set('account', $('#edit-admin-account').val());
                    $.ajax({
                        url: "function.php?op=signupCheckAjax",
                        data: formData,
                        type: "POST",
                        dataType: 'text',
                        processData: false,
                        contentType: false,
                        success: function(msg) {
                            $('#account_check').text(msg); 
                            if(msg != "此帳號已存在!")
                            {
                                $('.edit-model').fadeOut(400);
                                admin_CRUD();
                            }
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            alert(xhr.status);
                            alert(thrownError);
                        }
                    }); 
                } 
                else{
                    $('.edit-model').fadeOut(400);
                    admin_CRUD();
                }         
          },
          rules: {
                "edit-admin-account": {
                    required: true,
                    minlength: 4,
                    maxlength: 24
                },
                "edit-admin-email": {
                    required: true,
                    email: true
                },
                "edit-admin-password": {
                    required: {
                        depends: function(element) {
                            if ($("#oper").val() == 'insert') {
                                return true;
                            } else {
                                return false;
                            }
                        }
                    },
                    pwd: {
                        depends: function(element) {
                            if ($("#oper").val() == 'insert') {
                                return true;
                            } else {
                                return false;
                            }
                        }
                    }
                },
                "edit-admin-pwd": {
                    required: {
                        depends: function(element) {
                            if ($("#oper").val() == 'insert') {
                                return true;
                            } else {
                                return false;
                            }
                        }
                    },
                    equalTo: {
                        param: '#edit-admin-password',
                        depends: function(element) { 
                            return $("#oper").val() == 'insert'; 
                        }
                    }
                },
                "edit-admin-name": {
                    required: true
                },
                "edit-admin-phone": {
                    required: true,
                    matches: new RegExp('^09\\d{8}$')
                }
            },
            messages: {
                "edit-admin-account":{
                    required: "請輸入管理員帳號",
                    minlength: "請輸入4到24位英數字組合",
                    maxlength: "請輸入4到24位英數字組合"
                },
                "edit-admin-email": {
                    required: "請輸入電子郵箱",
                    email: "請輸入正確郵箱格式"
                },
                "edit-admin-password": {
                    required: "請輸入密碼"
                },
                "edit-admin-pwd": {
                    required: "請輸入確認密碼",
                    equalTo: "密碼不相符"
                },
                "edit-admin-name": {
                    required: "請輸入管理員名稱"
                },
                "edit-admin-phone": {
                    required: "請輸入電話號碼",
                    matches: "請輸入正確的10位手機格式"
                }
            }
        });

        function admin_CRUD() {
            $.ajax({
                url: "crud.php",
                data: $("#edit-admin-form").serialize(),
                type: 'POST',
                dataType: "json",
                success: function(JData) {                 
                    $("#edit-admin-form").get(0).reset();
                    admin_validator.resetForm();
                    $("#edit-admin-account").prop('readonly', false);
                      if (JData.code){
                            toastr.error(JData.message);
                            console.log(JData.message);
                      }
                      else {
                            $("#oper").val("insert");
                            admin_tbl.ajax.reload();   
                            toastr.success(JData.message);    
                      }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    $("#edit-admin-form").get(0).reset();
                    admin_validator.resetForm();
                    $("#edit-admin-account").prop('readonly', false);
                    console.log(xhr.responseText);
                    alert(xhr.responseText);
                }
            });
        }

        /************************
         *      評論CRUD        *
         ************************/
        //查詢
        var comment_tbl = $('#comment_datatable').DataTable({
            scrollCollapse: true,
            autoWidth: false,
            responsive: true,
            "ajax": {
                url: "crud.php",
                data: function(d) {
                      return $('#edit-comment-form').serialize() + "&oper=query";
                },
                type: 'POST',
                dataType: 'json'
            },
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "language": {
                "processing": "處理中...",
                "loadingRecords": "載入中...",
                "lengthMenu": "顯示 _MENU_ 項結果",
                "zeroRecords": "沒有符合的結果",
                "info": "顯示第 _START_ 至 _END_ 項結果，共 _TOTAL_ 項",
                "infoEmpty": "顯示第 0 至 0 項結果，共 0 項",
                "infoFiltered": "(從 _MAX_ 項結果中過濾)",
                "infoPostFix": "",
                "search": "搜尋:",
                "paginate": {
                    "first": "第一頁",
                    "previous": "上一頁",
                    "next": "下一頁",
                    "last": "最後一頁"
                }    
            }
        });

        //刪除
        $('tbody').on('click', '#comment_delete', function() {
          var data = comment_tbl.row($(this).closest('tr')).data();
          if (!confirm('是否確定要刪除?'))
                return false;
            $("#tableType").val("commentTable");
            $("#oper").val("delete");
            $("#comment_game_ID").val(data[0]);
            $("#comment_member_account").val(data[2]); 
            $("#comment_datetime").val(data[3]);  
            comment_CRUD();
       }); 

        //取消
        $('#comment_cancel').on('click', function () {         
            $("#oper").val("update");
            $("#edit-comment-form").get(0).reset();
            comment_validator.resetForm();
            $("#comment-name-view").text('');
            $("#comment-account-view").text('');
            $("#comment-datetime-view").text(''); 
            $('.edit-model').fadeOut(400);
        });

        //修改
        $('tbody').on('click', '#comment_update', function() {
            var data = comment_tbl.row($(this).closest('tr')).data();
            $("#comment_game_ID").val(data[0]);
            $("#comment_member_account").val(data[2]); 
            $("#comment_datetime").val(data[3]); 
            $("#edit-comment").val(data[4]); 

            $("#comment-name-view").html(data[1]);
            $("#comment-account-view").html('<span>會員帳號:</span>'+data[2]);
            $("#comment-datetime-view").html('<span>評論時間:</span>'+data[3]);

            $("#tableType").val("commentTable");
            $("#oper").val("update");
        });

        var comment_validator = $("#edit-comment-form").validate({
            submitHandler: function() {
                $('.edit-model').fadeOut(400);
                comment_CRUD();
            },
            rules: {
                "edit-comment": {
                    required: true
                }            
            },
            messages: {
                "edit-comment":{
                    required: "請輸入評論內容"
                }     
            }
        });

        function comment_CRUD() {
            $.ajax({
                url: "crud.php",
                data: $("#edit-comment-form").serialize(),
                type: 'POST',
                dataType: "json",
                success: function(JData) {
                    $("#edit-comment-form").get(0).reset();
                    comment_validator.resetForm();                 
                      if (JData.code){
                            toastr.error(JData.message);
                            console.log(JData.message);
                      }
                      else {
                            $("#oper").val("update");
                            comment_tbl.ajax.reload();   
                            toastr.success(JData.message);
                      }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    $("#edit-comment-form").get(0).reset();
                    comment_validator.resetForm();
                    console.log(xhr.responseText);
                    alert(xhr.responseText);
                }
            });
        }

});