jQuery(window).on('load',function(){

  'use strict';

  var URL = window.URL || window.webkitURL;
  var container = document.querySelector('.img-container');
  var image = container.getElementsByTagName('img').item(0);
  var download = document.getElementById('download');
  var actions = document.getElementById('actions');
  var options = {
    aspectRatio: NaN,
    preview: '.img-preview',
    ready: function (e) {
      console.log(e.type);
    },
    cropstart: function (e) {
      console.log(e.type, e.detail.action);
    },
    cropmove: function (e) {
      console.log(e.type, e.detail.action);
    },
    cropend: function (e) {
      console.log(e.type, e.detail.action);
    },
    crop: function (e) {
      var data = e.detail;
      console.log(e.type);
    },
    zoom: function (e) {
      console.log(e.type, e.detail.ratio);
    }
  };

  var cropper; 
  $(document).on('click', '#game_update', function() {
    cropper = new Cropper(image, options);
  });
  $(document).on('click', '#game_insert', function() {
    cropper = new Cropper(image, options);
  });

  //var cropper = new Cropper(image, options);
  var originalImageURL = image.src;

  var uploadedImageType = 'image/jpeg';
  var uploadedImageName = 'cropped.jpg';
  var uploadedImageURL;


  // Buttons
  if (!document.createElement('canvas').getContext) {
    console.log('1') ; 
    $('button[data-method="edit-save"]').prop('disabled', true);
  }

  if (typeof document.createElement('cropper').style.transition === 'undefined') {
    $('button[data-method="rotate"]').prop('disabled', true);
    $('button[data-method="scale"]').prop('disabled', true);
  }

  // Download
  if (typeof download.download === 'undefined') {
    download.className += ' disabled';
  }

  // Methods
  actions.querySelector('.docs-buttons').onclick = function (event) {
    var e = event || window.event;
    var target = e.target || e.srcElement;
    var cropped;
    var result;
    var input;
    var data;

    if (!cropper) {
      return;
    }

    while (target !== this) {
      if (target.getAttribute('data-method')) {
        break;
      }

      target = target.parentNode;
    }

    if (target === this || target.disabled || target.className.indexOf('disabled') > -1) {
      return;
    }

    data = {
      method: target.getAttribute('data-method'),
      target: target.getAttribute('data-target'),
      option: target.getAttribute('data-option') || undefined,
      secondOption: target.getAttribute('data-second-option') || undefined
    };

    cropped = cropper.cropped;

    if (data.method) {
      if (typeof data.target !== 'undefined') {
        input = document.querySelector(data.target);

        if (!target.hasAttribute('data-option') && data.target && input) {
          try {
            data.option = JSON.parse(input.value);
          } catch (e) {
            console.log(e.message);
          }
        }
      }

      switch (data.method) {
        case 'rotate':
          if (cropped && options.viewMode > 0) {
            cropper.clear();
          }

          break;

      }

      result = cropper[data.method](data.option, data.secondOption);

      switch (data.method) {
        case 'rotate':
          if (cropped && options.viewMode > 0) {
            cropper.crop();
          }

          break;

        case 'scaleX':
        case 'scaleY':
          target.setAttribute('data-option', -data.option);
          break;

        case 'destroy':
          cropper = null;

          if (uploadedImageURL) {
            URL.revokeObjectURL(uploadedImageURL);
            uploadedImageURL = '';
            image.src = originalImageURL;
          }

          break;

      }

      if (typeof result === 'object' && result !== cropper && input) {
        try {
          input.value = JSON.stringify(result);
        } catch (e) {
          console.log(e.message);
        }
      }
    }
  };

  document.body.onkeydown = function (event) {
    var e = event || window.event;

    if (!cropper || this.scrollTop > 300) {
      return;
    }

    switch (e.keyCode) {
      case 37:
        e.preventDefault();
        cropper.move(-1, 0);
        break;

      case 38:
        e.preventDefault();
        cropper.move(0, -1);
        break;

      case 39:
        e.preventDefault();
        cropper.move(1, 0);
        break;

      case 40:
        e.preventDefault();
        cropper.move(0, 1);
        break;
    }
  };

  $(document).on('click', '#game_save', function() {
    var gameID = $('#edit-game_ID').val();
    var oper = $("#oper").val();
    var canvas;
    if (cropper) {
      canvas = cropper.getCroppedCanvas({
        width: 320,
        height: 180,
      });
      uploadedImageURL = canvas.toDataURL();
      canvas.toBlob(function (blob) {
        var formData = new FormData();
        formData.append('uploadImage', blob, 'cropped.jpg');
        formData.append('game_ID', gameID);
        formData.append('oper', oper);
        $.ajax({
          url: "uploadImage.php",
          method: 'POST',
          data: formData,
          dataType: "json",
          processData: false,
          contentType: false,
          success: function(JData) {   
              $("#image").attr("src","img/product/default.png");
              cropper.clear();             
              if (JData.code){
                    toastr.error(JData.message);
                    console.log(JData.message);
              }
              else{
                    toastr.success(JData.message);
                    console.log(JData.message);
              }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                $("#image").attr("src","img/product/default.png");
                cropper.clear();
                console.log(xhr.responseText);
                alert(xhr.responseText);
            } 
        });
      });
    }
  });

  // Import image
  var inputImage = document.getElementById('inputImage');

  if (URL) {
    inputImage.onchange = function () {
      var files = this.files;
      var file;

      if (cropper && files && files.length) {
        file = files[0];

        if (/^image\/\w+/.test(file.type)) {
          uploadedImageType = file.type;
          uploadedImageName = file.name;

          if (uploadedImageURL) {
            URL.revokeObjectURL(uploadedImageURL);
          }

          image.src = uploadedImageURL = URL.createObjectURL(file);
          cropper.destroy();
          cropper = new Cropper(image, options);
          inputImage.value = null;
        } else {
          window.alert('Please choose an image file.');
        }
      }
    };
  } else {
    inputImage.disabled = true;
    inputImage.parentNode.className += ' disabled';
  }

  $(document).on('click', '#game_cancel', function() {
    $("#image").attr("src","img/product/default.png");
    cropper.destroy();
    cropper = null;
  });

});