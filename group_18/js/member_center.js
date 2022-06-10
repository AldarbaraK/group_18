/*------------------
    會員中心
--------------------*/

jQuery(document).ready(function($) {

        /************************
         *      會員收藏庫        *
         ************************/

        //查詢
        var collection_tbl = $('#collection_datatable').DataTable({
            scrollCollapse: true,
            autoWidth: false,
            responsive: true,
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

        //取消
        $('#collection_cancel').on('click', function () {         
            $("#oper").val("update");
            $("#member-collection").get(0).reset();
            collection_validator.resetForm();
            $("#game-name-view").text('');
            $("#member-account-view").text('');
            $("#deal_rating").val(''); 
            $('.edit-model').fadeOut(400);
        });

        //修改
        $('tbody').on('click', '#collection_update', function() {
            var data = collection_tbl.row($(this).closest('tr')).data();
            $("#game_name").val(data[1]);
            $("#game-name-view").text(data[1]);
            $('#deal_rating').rating({ }).rating('update',$(this).closest('tr').find('#deal_rating_view').val());
            $("#member-account-view").text('會員帳號 :'+$("#member_account").val());
            $("#game_ID").val($(this).closest('td').find('#tbl_game_ID').val());

            $("#tableType").val("collectionTable");
            $("#oper").val("update");
        });

        var collection_validator = $("#member-collection").validate({
            submitHandler: function() {
                $('.edit-model').fadeOut(400);
                collection_CRUD();
            },
        });

        function collection_CRUD() {
            $.ajax({
                url: "crud.php",
                data: $("#member-collection").serialize(),
                type: 'POST',
                dataType: "json",
                success: function(JData) {
                    $("#member-collection").get(0).reset();
                    collection_validator.resetForm();                
                      if (JData.code){
                            toastr.error(JData.message);
                            console.log(JData.message);
                      }
                      else {
                            $("#oper").val("update");
                            toastr.success(JData.message);
                            location.reload();  
                      }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    $("#member-collection").get(0).reset();
                    collection_validator.resetForm();
                    console.log(xhr.responseText);
                    alert(xhr.responseText);
                }
            });
        }        

        /************************
         *      會員CRUD        *
         ************************/      
        //修改
        $('tbody').on('click', '#member_update', function() {
            $("#tableType").val("memberTable");
            $("#oper").val("update");
        });

       //取消
       $(document).on('click', '#member_cancel', function() {
            $('.edit-model').fadeOut(400);        
            $("#oper").val("update");
            $("#edit-member-form").get(0).reset(); 
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
        
        var member_validator = $("#edit-member-form").validate({
          submitHandler: function() {
                $('.edit-model').fadeOut(400);
                member_CRUD();            
          },
          rules: {
                "edit-member-email": {
                    required: true,
                    email: true
                },
                "edit-member-pwd": {
                    equalTo: "#edit-member-password"
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
                "edit-member-email": {
                    required: "請輸入電子郵箱",
                    email: "請輸入正確郵箱格式"
                },
                "edit-member-pwd": {
                    equalTo: "密碼不相符"
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
                      if (JData.code){
                            toastr.error(JData.message);
                            console.log(JData.message);
                      }
                      else {
                            $("#oper").val("update");  
                            toastr.success(JData.message);
                            location.reload();   
                      }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    $("#edit-member-form").get(0).reset();
                    console.log(xhr.responseText);
                    alert(xhr.responseText);
                }
            });
        }

});