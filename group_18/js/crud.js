/*------------------
    crud
--------------------*/

jQuery(document).ready(function($) {
        //修改
        $('tbody').on('click', '#btn_update', function() {
            var data = $('#product_table').DataTable().row(this).data();     
            $('#edit-game-name').val(data[2]);
            $('#edit-game-date').val(data[3]);
            let language = data[4].split('/');
            for(var i=0;i<language.length;i++){
                if(language[i] == "繁體中文")
                    $('input[name="game_lang"][value=1]').prop('checked', true);
                else if(language[i] == "英文")
                    $('input[name="game_lang"][value=2]').prop('checked', true);
                else if(language[i] == "日文")
                    $('input[name="game_lang"][value=3]').prop('checked', true);
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
           $("#edit-game-story").val(data[11]);
           $("#oper").val("update");
        });

       //取消
       $('#btn_cancel').on('click', function() {
          $("#oper").val("insert");
          $('.edit-model').fadeOut(400);         
       });

       //刪除
       $('tbody').on('click', '#btn_delete', function() {
          var data = $('#product_table').DataTable().row(this).data();
          if (!confirm('是否確定要刪除?'))
                return false;

          $("#edit-game_ID").val(data[1]);
          $("#oper").val("delete"); //刪除
          CRUD();
       });

       //送出表單 (儲存)

       $("#edit-game-form").validate({
          submitHandler: function(form) {
                $('.edit-model').fadeOut(400);
                CRUD();          
          },
          rules: {
                "edit-game-name": {
                    required: true
                },
                "edit-game-date": {
                    required: true
                },
                game_lang: {
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
        function CRUD() {
            $.ajax({
                url: "crud.php",
                data: $("#edit-model-form").serialize(),
                type: 'POST',
                dataType: "json",
                success: function(JData) {
                      if (JData.code)
                            toastr["error"](JData.message);
                      else {
                             $("#oper").val("insert");
                            toastr["success"](JData.message);
                            tbl.ajax.reload();
                      }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                      console.log(xhr.responseText);
                      alert(xhr.responseText);
                }
            });
        }
});