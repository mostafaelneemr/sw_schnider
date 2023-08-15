(function ($) {

     $.fn.tree = function (options) {

          var settings = $.extend({

               getLocations : "",
               saveLocations: "",
               href: ""
          } , options);

          var tree = [];

          var selector = $(this);

          $.ajax({
               url : settings.getLocations,
               headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               },
               success : data => {
                   
                    tree = data.data.map(item => {
                         return {
                              parent : item.parent_id,
                              ...item
                         }
                    });
                    
                    draw();
               }
          })


          function addStartBtn() {

               const btn = $('<button>Add Start</button>').addClass('btn btn-primary btn-lg btn-block');

               selector.append(btn);

               btn.click(() => {
                    addSubLocation(null);
               });
          }



          function draw() {

               selector.empty();

               const root = tree.find(item => item.parent == null);

               if (!root) return addStartBtn();

               selector.append(generateTreeItem(root));

               // collapse
               selector.find('.tree-collapse').off('click');

               selector.find('.tree-collapse').click(function (e) {

                    

                    e.stopPropagation();

                    $(this).closest('.tree-item').find('.tree-item-child').slideToggle();

                    if (this.classList.contains('flaticon2-up')) {

                         this.classList.replace('flaticon2-up', 'flaticon2-down')
                    } else {
                         this.classList.replace('flaticon2-down', 'flaticon2-up')

                    }
               });


               //change parent 

               selector.find('.change-parent').click(function () {

                    changeParentLocation(this.dataset.id);
               });

               //add sub 

               selector.find('.add-sub-location').click(function () {

                    addSubLocation(this.dataset.id);
               });

               //rename

               selector.find('.rename').click(function () {

                    rename(this.dataset.id);
               });

               //rename

               selector.find('.remove').click(function () {

                    remove(this.dataset.id);
               });


          }



          function generateTreeItem(item) {

               const childs = tree.filter(child => child.parent == item.id);

               let template = ` <div class="tree-item text-dark" id="${item.id}">
            <div class="d-flex align-items-baseline justify-content-between px-4 py-2 tree-item-head rounded">
                <div  class="d-flex align-items-baseline">
                    ${childs.length ? '<i class="flaticon2-up tree-collapse"></i>' : '<div class="ml-3 d-inline-block"></div>'}
                    <a href="${settings.href}?location_id=${item.id}" class="mb-0 ml-3 d-inline-block text-truncate font-size-h5 text-dark font-weight-bold" style="width:100px;">${item.name}</a>
                </div>

                <div class="dropdown dropdown-inline mr-4">
                    <button type="button" class="btn  btn-icon btn-sm" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <i class="ki ki-bold-more-hor text-dark"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item d-flex align-items-center rename" data-id="${item.id}" href="#">
                            <i class="flaticon2-edit mr-3"></i>
                            rename
                        </a>
                        <a class="dropdown-item d-flex align-items-center add-sub-location" data-id="${item.id}" href="#">
                            <i class="flaticon2-plus mr-3"></i>
                            add sub location
                        </a>
                        <a class="dropdown-item d-flex align-items-center change-parent" data-id="${item.id}" href="#">
                            <i class="flaticon2-size mr-3"></i>
                            change parent location
                        </a>
                        <a class="dropdown-item d-flex align-items-center remove" data-id="${item.id}" href="#"> <i class="flaticon2-trash mr-3"></i> remove location </a>  

                    </div>
                </div>
            </div>
            <div class="tree-item-child"> `;


               childs.forEach(child => {

                    template += generateTreeItem(child);
               })




               template += '</div></div>';

               return template;

          }


          function changeParentLocation(id) {

               const parent = tree.find(item => item.id == id).parent;

               let template = `<div class="modal change-parent-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form class="modal-content">
            <div class="modal-body">
               <p>Choose Parent</p>
                 <select class="form-control select2" name="parent">

              `;


               tree.forEach(item => {

                    if (item.id != id) {

                         template += `<option value=${item.id} ${parent == item.id ? 'selected' : ''}>${item.name}</option>`
                    }
               })



               template += `   </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Change</button>
            </div>
        </form>
    </div>
</div>`


               $('body').append(template);

               $('.change-parent-modal').modal('show');

               $('.change-parent-modal').on('hidden.bs.modal', function (e) {
                    $('.change-parent-modal').remove();
               })

               $('.change-parent-modal form').submit(function (e) {

                    e.preventDefault();

                    const parent = this.elements[0].value;


                    tree.find(item => item.id == id).parent = parent;

                    sync('change_parent' , {location_id:id , parent})

                    draw();


                    $('.change-parent-modal').modal('hide');
               })

               $('.select2').select2();

          }

          function addSubLocation(id) {

               let template = `<div class="modal add-sub-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form class="modal-content">
            <div class="modal-body">
               <div class="form-group">
                  <label class="form-label">name</label>
                  <input type="text" class="form-control" name="name" />
                    </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Add</button>
            </div>
        </form>
    </div>
</div>`


               $('body').append(template);

               $('.add-sub-modal').modal('show');

               $('.add-sub-modal').on('hidden.bs.modal', function (e) {
                    $('.add-sub-modal').remove();
               })

               $('.add-sub-modal form').submit(function (e) {

                    e.preventDefault();

                    const name = this.elements[0].value;

                    const data = {
                         id: Math.floor(Math.random() * 1000),
                         name,
                         parent: id ? id : 0
                    };

                    tree.push( data );

                    sync('add_sub' , data );

                    draw();


                    $('.add-sub-modal').modal('hide');
               })



          }
          function rename(id) {

               const item = tree.find(item => item.id == id);

               let template = `<div class="modal rename-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form class="modal-content">
            <div class="modal-body">
               <div class="form-group">
                  <label class="form-label">name</label>
                  <input type="text" class="form-control" name="name" value="${item.name}" />
                    </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Change</button>
            </div>
        </form>
    </div>
</div>`


               $('body').append(template);

               $('.rename-modal').modal('show');

               $('.rename-modal').on('hidden.bs.modal', function (e) {
                    $('.rename-modal').remove();
               })

               $('.rename-modal form').submit(function (e) {

                    e.preventDefault();

                    const name = this.elements[0].value;


                    item.name = name;

                    sync('rename' , {location_id : id , name} );

                    draw();


                    $('.rename-modal').modal('hide');
               })



          }
          function remove(id) {

               let template = `<div class="modal remove-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form class="modal-content">
            <div class="modal-body">
               <div class="form-group">
                  
                    Are you sure to remove ?
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-danger">remove</button>
            </div>
        </form>
    </div>
</div>`


               $('body').append(template);

               $('.remove-modal').modal('show');

               $('.remove-modal').on('hidden.bs.modal', function (e) {
                    $('.remove-modal').remove();
               })

               $('.remove-modal form').submit(function (e) {

                    e.preventDefault();


                    const index = tree.findIndex(item => item.id == id);

                    tree.splice(index, 1);

                    sync('delete' , {location_id : id});

                    draw();


                    $('.remove-modal').modal('hide');
               })



          }

          function sync(action , data){

               $.ajax({
                    url :settings.saveLocations,
                    method:"POST",
                    data : { action , ...data},
                    headers: {
                         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                     }
               });
          }
     };

}($));

