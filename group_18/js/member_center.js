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

});