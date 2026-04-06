(function () {
   var cropper = null;
   var currentTargetInput = null;
   var objectUrl = null;

   var modal = document.getElementById('image-crop-modal');
   var cropImg = document.getElementById('crop-modal-img');
   var btnCancel = document.getElementById('crop-modal-cancel');
   var btnApply = document.getElementById('crop-modal-apply');
   var backdrop = modal ? modal.querySelector('.crop-modal__backdrop') : null;

   if (!modal || !cropImg || !btnCancel || !btnApply) {
      return;
   }

   function closeModal() {
      modal.classList.remove('is-open');
      modal.setAttribute('aria-hidden', 'true');
      if (cropper) {
         cropper.destroy();
         cropper = null;
      }
      if (objectUrl) {
         URL.revokeObjectURL(objectUrl);
         objectUrl = null;
      }
      cropImg.removeAttribute('src');
      currentTargetInput = null;
   }

   function openModal(file, targetInput) {
      currentTargetInput = targetInput;
      if (cropper) {
         cropper.destroy();
         cropper = null;
      }
      if (objectUrl) {
         URL.revokeObjectURL(objectUrl);
         objectUrl = null;
      }
      objectUrl = URL.createObjectURL(file);
      cropImg.onload = function () {
         cropImg.onload = null;
         cropper = new Cropper(cropImg, {
            aspectRatio: 2 / 3,
            viewMode: 1,
            autoCropArea: 1,
            responsive: true,
            background: false
         });
      };
      cropImg.src = objectUrl;
      modal.classList.add('is-open');
      modal.setAttribute('aria-hidden', 'false');
   }

   function cancelCrop() {
      if (currentTargetInput) {
         currentTargetInput.value = '';
      }
      closeModal();
   }

   btnCancel.addEventListener('click', cancelCrop);
   if (backdrop) {
      backdrop.addEventListener('click', cancelCrop);
   }

   btnApply.addEventListener('click', function () {
      if (!cropper || !currentTargetInput) {
         return;
      }
      var canvas = cropper.getCroppedCanvas({
         width: 800,
         height: 1200,
         imageSmoothingQuality: 'high'
      });
      if (!canvas) {
         return;
      }
      canvas.toBlob(function (blob) {
         if (!blob) {
            return;
         }
         var orig = currentTargetInput.files && currentTargetInput.files[0];
         var base = 'product';
         if (orig && orig.name) {
            base = orig.name.replace(/\.[^.]+$/, '');
         }
         var name = 'cropped-' + Date.now() + '.jpg';
         var outFile = new File([blob], name, { type: 'image/jpeg', lastModified: Date.now() });
         var dt = new DataTransfer();
         dt.items.add(outFile);
         currentTargetInput.files = dt.files;
         closeModal();
      }, 'image/jpeg', 0.92);
   });

   document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && modal.classList.contains('is-open')) {
         cancelCrop();
      }
   });

   function bindImageInput(input) {
      if (!input) {
         return;
      }
      input.addEventListener('change', function (e) {
         var file = e.target.files && e.target.files[0];
         if (!file) {
            return;
         }
         if (file.type && !/^image\/(jpeg|png)$/i.test(file.type)) {
            e.target.value = '';
            alert('Please choose a JPEG or PNG image.');
            return;
         }
         openModal(file, input);
      });
   }

   bindImageInput(document.getElementById('product-image-input'));
   bindImageInput(document.getElementById('update-product-image-input'));

   var addForm = document.getElementById('add-product-form');
   var addImageInput = document.getElementById('product-image-input');
   if (addForm && addImageInput) {
      addForm.addEventListener('submit', function (e) {
         if (!addImageInput.files || !addImageInput.files.length) {
            e.preventDefault();
            alert('Please choose an image, crop it, and click "Use cropped image" before adding the product.');
         }
      });
   }
})();
