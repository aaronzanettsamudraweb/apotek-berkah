<?php if (isset($_SESSION['alert']['action'])) : ?>
    <div class="" id="alert" 
    data-alertheader="<?= $_SESSION['alert']['header'] ?>"
    data-alertdescription="<?= $_SESSION['alert']['description'] ?>"
    data-alerttype="<?= $_SESSION['alert']['type'] ?>"
    data-alertaction="<?= $_SESSION['alert']['action'] ?>"
    ></div>
<?php endif; SetAlert::deleteAlert(); ?> 

<section id="kategori">
    <div class="tabledata shadow">
        <div class="pagetitle-tabledata">
            <h2 class="pageTitle">Master Kategori</h2>
            <button class="btn edit openModalBtn tabledata-addbtn add-kategori"><i class="bi bi-plus-lg"></i> Tambah kategori</button>
        </div>

        <div class="tabledata-header">
            <div class="tabledata-group">
                <i class="bi bi-search tabledata-searchicon"></i>
                <input type="text" class="tabledata-searchinput tabledata-kategori-search" placeholder="Cari kategori...">
            </div>
        </div>

        <div class="tabledata-subheader">
            <p class="tabledata-totaldata">Total <?= count($data['kategori']) ?> kategori</p>
        </div>

        <div class="tabledata-body">
            <div class="tabledata-body-overflow-sm">
                <div class="tabledata-header">
                    <p>No</p>
                    <p>Nama Kategori</p>
                    <p>Actions</p>
                </div>
    
                <form action="<?= BASEURL ?>/headofficeOpp/deleteManyKategori" method="post" class="alertConfirmKategori2">
                    <div id="tabledata-items">
                        <?php if (count($data['kategori']) !== 0) { ?>
                            <?php $i = 1; foreach ($data['kategori'] as $kategori ) : ?>
                                <div class="tabledata-item">
                                    <p class="no"><?= $i++ ?></p><input type="checkbox" class="tabledata-choose-checkbox d-none" name="deletemanykategori[]" id="<?= $kategori['id'] ?>" value="<?= $kategori['id'] ?>">
                                    <p><?= $kategori['name'] ?></p>
                                    <div class="tabledata-actions">
                                        <div class="action openModalBtn edit-kategori" data-id="<?= $kategori['id'] ?>"><i class="bi bi-pencil"></i></div>
                                        <a href="<?= BASEURL ?>/headofficeOpp/deletekategori/<?= $kategori['id'] ?>" class="action alertConfirmKategori"><i class="bi bi-trash"></i></a>
                                    </div>
                                </div>
                            <?php endforeach;?>
                            <?php } else { ?>
                            <div class="tabledata-item" id="tabledata-item-datanotfound-dataempty">data masih kosong</div>
                        <?php } ?>
                    </div>
                <?php if (count($data['kategori']) !== 0) { ?>
                    <div class="tabledata-footer">
                        <div class="choose-items">
                            <button type="button" class="btn edit tabledata-choose">Pilih kategori</button>
                            <button type="button" class="btn cancel tabledata-choose-cancel d-none">Batal</button>
                            <button type="submit" class="btn delete tabledata-choose-delete d-none">Hapus</button>
                        </div>
                    </div>
                    <?php } else {} ?>
                </form>
            </div>
        </div>

    </div>

    <div id="modal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close closeButton">&times;</span>
                <h2 class="modal-title">Modal Title</h2>
            </div>
            <div class="modal-data">
                <div class="modal-body">
                    <form action="<?= BASEURL ?>/headofficeOpp/addKategori" method="post">
                        <input type="hidden" name="id" id="id" value="id">

                        <div class="form-group">
                            <label for="name">Nama Kategori</label>
                            <input type="text" id="name" name="name" required maxlength="50">
                        </div>
                        
                        <div class="configAlert d-none">
                            <p>Nama kategori sudah digunakan!</p>
                        </div>
                        
                        <div class="modal-footer">
                            <button type="button" class="btn cancel close">Cancel</button>
                            <button type="submit" class="btn edit">save</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-detail d-none">
                <div class="modal-detail-header"></div>
                <div class="modal-detail-body"></div>
                <div class="modal-detail-footer">
                    <button type="button" class="btn cancel close">Close</button>
                </div>
            </div>
        </div>
    </div>
</section>


<script>
$(function () {
    //add 
    $(".add-kategori").on("click", function () {
        $(".modal-title").html("Tambah kategori baru");
        $(".modal-footer button[type=submit]").html("Tambah");
        $(".modal-body form").attr("action", "<?= BASEURL ?>/headofficeOpp/addKategori" );
        $('.configAlert').addClass('d-none')
        $(".modal-footer button[type=submit]").removeClass('disabled')
        $("#id").val(''),
        $("#name").val('')
    });

    function crudOperation(){  
        // delete confirm custom
        $('.alertConfirmKategori').on('click', function(e) {
            const href = $(this).attr('href');
            e.preventDefault();
            Swal.fire({
            title: "Apakah Anda Yakin?",
            text: "Semua produk yang berkaitan dengan kategori ini akan ikut terhapus!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, hapus!",
            reverseButtons: true
            }).then((result) => {
            if(result.isConfirmed) {
                document.location.href = href;
            }
            });
        })
        // delete many confirm custom
        $('.alertConfirmKategori2').on('submit', function(e) {
            e.preventDefault();
            const form = this;
            Swal.fire({
                title: "Apakah Anda Yakin?",
                text: "Semua produk yang berkaitan dengan kategori ini akan ikut terhapus!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, hapus!",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });

        // edit
        $(".edit-kategori").on("click", function () {
            $(".modal-title").html("Edit kategori");
            $(".modal-footer button[type=submit]").html("Edit");
            $(".modal-body form").attr("action","<?= BASEURL ?>/headofficeOpp/editKategori");
            $('.configAlert').addClass('d-none')
            $(".modal-footer button[type=submit]").removeClass('disabled')

            const id = $(this).data("id");
    
            $.ajax({
            url: "<?= BASEURL ?>/headofficeOpp/getDataEditkategori",
            data: {id: id},
            method: "post",
            dataType: "json",
            success: function (data) {
                $("#id").val(data.id),
                $("#name").val(data.name)
            },
            });
    
        });

        // delete many items
        $(".tabledata-choose").on('click', function() {
            $(".no").addClass('d-none');
            $(".tabledata-choose-checkbox").removeClass('d-none')
            $(".tabledata-choose").addClass('d-none')
            $(".tabledata-choose-cancel").removeClass('d-none')
            $(".tabledata-choose-delete").removeClass('d-none')
        })
        $(".tabledata-choose-cancel").on('click', function() {
            $(".no").removeClass('d-none');
            $(".tabledata-choose-checkbox").addClass('d-none')
            $(".tabledata-choose").removeClass('d-none')
            $(".tabledata-choose-cancel").addClass('d-none')
            $(".tabledata-choose-delete").addClass('d-none')

            $(".tabledata-choose-checkbox").prop('checked', false);
            $(".tabledata-choose-delete").text(`Hapus`)
        })
        $(".tabledata-choose-delete").addClass('disabled');

        function countItemsChoosed() {
            let count = 0;
            $(".tabledata-choose-checkbox").each(function() {
                if (this.checked) {
                    count++;
                }
            });

            if(count !== 0){
                $(".tabledata-choose-delete").text(`Hapus (${count})`);
                $(".tabledata-choose-delete").removeClass('disabled');
            } else {
                $(".tabledata-choose-delete").text(`Hapus`);
                $(".tabledata-choose-delete").addClass('disabled');
            }
        }

        $(".tabledata-choose-checkbox").on('change', function() {
            countItemsChoosed();
        });
    }

    crudOperation();

    // config
    $('#name').on('keyup', function() {
        let name = $(this).val();
        $.ajax({
            url: "<?= BASEURL ?>/headofficeOpp/getKategoriConfig",
            data: { name: name },
            method: "post",
            dataType: "json",
            success: function (data) {
                if($(".modal-footer button[type=submit]").html() == "Edit" ) {
                    let $id = $('#id').val();
                    if(data.id == $id) {
                        $('.configAlert').addClass('d-none')
                        $(".modal-footer button[type=submit]").removeClass('disabled')
                    } else if (data) {
                        $('.configAlert').removeClass('d-none')
                        $(".modal-footer button[type=submit]").addClass('disabled')
                    } else {
                        $('.configAlert').addClass('d-none')
                        $(".modal-footer button[type=submit]").removeClass('disabled')
                    }
                } else if (data) {
                    $('.configAlert').removeClass('d-none')
                    $(".modal-footer button[type=submit]").addClass('disabled')
                } else {
                    $('.configAlert').addClass('d-none')
                    $(".modal-footer button[type=submit]").removeClass('disabled')
                }
            },
        })
    })

    // search
    $('.tabledata-kategori-search').on('keyup', function() {
        let keyword = $(this).val();
        $(".no").removeClass('d-none');
        $(".tabledata-choose-checkbox").addClass('d-none')
        $(".tabledata-choose").removeClass('d-none')
        $(".tabledata-choose-cancel").addClass('d-none')
        $(".tabledata-choose-delete").addClass('d-none')
        $(".tabledata-choose-checkbox").prop('checked', false);
        $(".tabledata-choose-delete").text(`Hapus`)

        $.ajax({
        url: "<?= BASEURL ?>/headofficeOpp/searchKategori",
        data: { keyword: keyword},
        method: "post",
        dataType: "json",
        success: function (data) {
            let i = 1;

            let kategori = "";
            data.forEach(k => {
                kategori += `<div class="tabledata-item">
                                    <p class="no">`+ i++ +`</p><input type="checkbox" class="tabledata-choose-checkbox d-none" name="deletemanykategori[]" id="`+ k.id +`" value="`+ k.id +`">
                                    <p>`+ k.name +`</p>
                                    <div class="tabledata-actions">
                                        <div class="action openModalBtn edit-kategori" data-id="`+ k.id +`"><i class="bi bi-pencil"></i></div>
                                        <a href="<?= BASEURL ?>/headofficeOpp/deletekategori/`+ k.id +`" class="action alertConfirmKategori"><i class="bi bi-trash"></i></a>
                                    </div>
                                </div>`;
            })

            if(data.length !== 0) {
                $('#tabledata-items').html(kategori)
            } else {
                $('#tabledata-items').html(`<div class="tabledata-item" id="tabledata-item-datanotfound-dataempty">
                    data tidak ditemukan !
                </div>`)
            }

            crudOperation();
        },

        });
    })

});
</script>

<script src="<?= BASEURL?>/assets/js/global-script.js"></script>