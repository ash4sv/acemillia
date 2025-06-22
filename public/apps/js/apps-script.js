const COMMISSION_RATE = parseFloat(
    document.head.querySelector('meta[name="commission-rate"]')?.content || '0'
);

var Apps = {
    init: function () {
        Apps.ajaxDocumentToken();
        Apps.ajaxSetup();
        Apps.addToCartShortCut('.shortcut-add-to-cart');
        Apps.addToWishlist('.wishlist-icon');
        Apps.applyPromoCode('promo-code', 'checkout-view', 'discount-details');
        Apps.createNewData();
        Apps.select2('.select2');
        Apps.socialMedia();
        Apps.flatpickrDate('.flatpickr-start');
        Apps.flatpickrDate('.flatpickr-end');
        Apps.jqueryuiDate('.jqueryui-date');
        Apps.flatpickrTime('.flatpickr-time-start');
        Apps.flatpickrTime('.flatpickr-time-end');
        Apps.getBoothType();
        Apps.fancyApps();
        Apps.summernote('.text-editor');
        Apps.btnPublishBtn();
        Apps.btnSubmissionBtn();
    },

    bulkDeleteMethod: function (idBtn, idContainer, csrf) {
        $('#' + idBtn).on('click', function (e) {
            e.preventDefault();  // Prevent default behavior

            const selectedIds = [];

            // Collect all selected checkboxes
            $('#' + idContainer + ' input[name="selected_ids[]"]:checked').each(function () {
                selectedIds.push($(this).val());
            });

            // Check if no items are selected
            if (selectedIds.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'No items selected',
                    text: 'Please select at least one item to delete.'
                });
                return;
            }

            // Show confirmation dialog
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to delete the data?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    const deleteUrl = $(this).data('bulk-delete-url');
                    console.log('Delete URL:', deleteUrl);  // Debugging

                    // AJAX request to delete the selected items
                    $.ajax({
                        url: deleteUrl,
                        method: 'POST',
                        data: {
                            selected_ids: selectedIds
                        },
                        success: function (response) {
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Deleted!',
                                    text: 'Data successfully deleted!.'
                                }).then(() => {
                                    // Reload DataTable
                                    $('#' + idContainer).DataTable().ajax.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: 'An error occurred. Please try again.'
                                });
                            }
                        },
                        error: function (xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'An error occurred. Please try again.'
                            });
                        },

                        beforeSend: function(xhr) {
                            xhr.setRequestHeader('X-CSRF-TOKEN', csrf);
                        }
                    });
                }
            });
        });
    },

    updateBoothPublishConfig: function (csrfToken, checkbox) {
        var boothAreaId = $(checkbox).data('id');
        var isPublished = $(checkbox).is(':checked') ? 1 : 0;
        var $table = $(checkbox).closest('table'); // Get the closest table element

        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to change the publication status?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, update it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: $(checkbox).data('url'),
                    type: 'POST',
                    data: {
                        _token: csrfToken,
                        id: boothAreaId,
                        published: isPublished
                    },
                    success: function (response) {
                        console.log(response);
                        Swal.fire('Success!', 'The publication status has been updated.', 'success');
                        // Refresh the DataTable
                        $table.DataTable().ajax.reload(); // Refresh the DataTable instance
                    },
                    error: function (xhr) {
                        console.error(xhr.responseText);
                        Swal.fire('Error!', 'There was an issue updating the status.', 'error');
                    }
                });
            } else {
                $(checkbox).prop('checked', !isPublished); // Reset checkbox state if not confirmed
            }
        });
    },

    applyPromoCode: function (idContainer, idContainer2 = null, idContainer3 = null) {
        var popUpTImer = 2000;

        $('#' + idContainer).on('click', '.btn-promo', function (event) {
            event.preventDefault();
            var promoCodeUrl  = $(this).data('apply-promo-url');
            var promoCodeCsrf = $(this).data('csrf-token');
            var promoCode     = $('#' + idContainer + ' input[name="promo_code"]').val();
            var sub_total     = $('#' + idContainer + ' input[name="sub_total"]').val();
            var total         = $('#' + idContainer + ' input[name="total"]').val();

            var cartTotal     = $('#' + idContainer2 + ' input[name="cart_total"]');
            var discountVal   = $('#' + idContainer2 + ' input[name="discount"]');
            var discountType  = $('#' + idContainer2 + ' input[name="discount_amount"]');
            var displayPrice  = $('#' + idContainer2 + ' .total-display span');

            var discountDisplay = $('#' + idContainer2);

            if (promoCode === '') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Promo Code',
                    text: 'Please enter a promo code.',
                    timer: popUpTImer,
                    customClass: {
                        confirmButton: "btn btn-warning"
                    }
                });
                return;
            }

            $.ajax({
                url: promoCodeUrl,
                type: 'POST',
                data: {
                    promo_code: promoCode,
                    sub_total: sub_total,
                    total: total
                },
                success: function (response) {
                    if (response.success)
                    {
                        Swal.fire({
                            icon: 'success',
                            title: 'Promo Code',
                            text: response.message,
                            timer: popUpTImer,
                        });
                        discountType.val(response.dis_amount);
                        discountVal.val(response.discount);
                        cartTotal.val(response.total.toFixed(2));
                        displayPrice.html( 'RM' + response.total.toFixed(2))
                    }
                },
                error: function (response) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Promo Code',
                        text: response.responseJSON.error,
                        timer: popUpTImer,
                    });
                },
                beforeSend: function(xhr) {
                    xhr.setRequestHeader('X-CSRF-TOKEN', promoCodeCsrf);
                }
            });

        });
    },

    fancyApps: function () {
        Fancybox.bind('[data-fancybox]', {

        })
    },

    getBoothType: function () {
        $('#boothAreas').on('change', function() {
            var boothAreaId = $(this).val();
            console.log('Selected Booth Area ID:', boothAreaId);
            Apps.loadBoothTypes(boothAreaId);
        });
    },

    loadBoothTypes: function(boothAreaId, selectedBoothType = null) {
        if (boothAreaId) {
            $.ajax({
                url: "/organizer/event/get-booth-type",
                type: "GET",
                data: { booth_area_id: boothAreaId },
                success: function(data) {
                    console.log('Booth Types received:', data);
                    var boothTypeSelect = $('#boothTypes');
                    boothTypeSelect.empty();
                    boothTypeSelect.append('<option value="">Select Booth Type</option>');
                    $.each(data, function(key, value) {
                        var selected = value.id == selectedBoothType ? 'selected' : '';
                        boothTypeSelect.append('<option value="'+ value.id +'" '+ selected +'>'+ value.name +'</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                }
            });
        } else {
            $('#boothTypes').empty();
            $('#boothTypes').append('<option value="">Select Booth Type</option>');
        }
    },

    initBootyAreaType: function () {
        // Get the selected booth area and booth type from the response
        var selectedBoothArea = $('#boothAreas').val();
        var selectedBoothType = $('#boothTypes').data('selected'); // Ensure this data attribute is set in the response
        if (selectedBoothArea) {
            Apps.loadBoothTypes(selectedBoothArea, selectedBoothType);
        }
    },

    createNewData: function() {
        // Append modal HTML to the body if it doesn't exist
        if (!$('#basicModal').length) {
            $('body').append(`
                <div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel1"></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <!-- Content will be loaded here -->
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-label-secondary m-0" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            `);
        }

        // Rebind the click event to handle dynamically loaded or existing buttons
        $(document).off('click', '[data-bs-toggle="modal"]').on('click', '[data-bs-toggle="modal"]', function() {
            var createUrl  = $(this).data('create-url');
            var modalTitle = $(this).data('create-title');

            // Get the modal-dialog element
            var $modalDialog = $('#basicModal .modal-dialog');
            // Reset to default classes: modal-dialog and default size modal-lg
            $modalDialog.attr('class', 'modal-dialog modal-lg');

            // 1. Scrollable: if the button has a non-empty data attribute, add the class
            // (If you want to check for a specific truthy value like "true", you may adjust the condition.)
            var scrollable = $(this).attr('data-modal-dialog-scrollable');
            if (scrollable === 'true') {
                $modalDialog.addClass('modal-dialog-scrollable');
            }

            // 2. Centered: if the attribute exists (even if empty), add the centered class
            var centered = $(this).attr('data-modal-dialog-centered');
            if (centered === 'true') {
                $modalDialog.addClass('modal-dialog-centered');
            }

            // 3. Optional Size: if a valid size class (e.g. modal-xl, modal-sm) is provided, override the default modal-lg
            var optionalSize = $(this).attr('data-modal-optional-size');
            if (typeof optionalSize !== 'undefined' && optionalSize !== "") {
                $modalDialog.removeClass('modal-lg').addClass(optionalSize);
            }

            // 4. Fullscreen Mode: if the attribute exists, add the appropriate fullscreen class.
            // If the attribute value is empty, default to "modal-fullscreen".
            var fullscreenMode = $(this).attr('data-modal-fullscreen-mode');
            if (fullscreenMode && fullscreenMode.trim() !== '') {
                $modalDialog.addClass(fullscreenMode);
            }

            // Load content via AJAX
            $.ajax({
                url: createUrl,
                method: 'GET',
                success: function(response) {
                    $('#basicModal .modal-body').html(response);
                    $('#basicModal .modal-title').text(modalTitle);
                    $('#basicModal').modal('show'); // Show the modal

                    // Initialize additional features if needed
                    Apps.select2('.select2');
                    Apps.socialMedia();
                    Apps.flatpickrDate('.flatpickr-start');
                    Apps.flatpickrDate('.flatpickr-end');
                    Apps.flatpickrTime('.flatpickr-time-start');
                    Apps.flatpickrTime('.flatpickr-time-end');
                    Apps.summernote('.text-editor');
                    Apps.getBoothType();
                    Apps.initBootyAreaType();
                    Apps.btnPublishBtn();
                    Apps.btnSubmissionBtn();
                    Apps.bindModalFormHandler().then((res) => {
                        console.log('✅ Modal form submitted successfully:', res);
                    }).catch((err) => {
                        console.error('❌ Modal form submission failed:', err);
                    });
                    Apps.bindDeleteHandler();
                },
                error: function(xhr) {
                    console.error('AJAX Error:', xhr.status, xhr.statusText);
                    $('#basicModal .modal-body').html('<p>Error loading content...</p>');
                }
            });
        });
    },

    bindModalFormHandler: function (formSelector = '#modal-form') {
        return new Promise((resolve, reject) => {
            $(formSelector).off('submit').on('submit', function (e) {
                e.preventDefault();

                const $form = $(this);
                const action = $form.attr('action');
                const rawMethod = $form.find('input[name="_method"]').val() || $form.attr('method') || 'POST';
                const method = rawMethod.toUpperCase();

                const formData = new FormData(this);

                // 👇 Ensure the spoofed method is included for Laravel
                if (method !== 'POST') {
                    formData.append('_method', method);
                }

                // Always use POST in the actual HTTP request
                const httpMethod = 'POST';

                // Clear previous errors
                $form.find('.is-invalid').removeClass('is-invalid');
                $form.find('.invalid-feedback').remove();

                $.ajax({
                    url: action,
                    method: httpMethod, // ✅ always POST in the request
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        if (response.modal) {
                            Swal.fire({
                                icon: response.type || 'success',
                                title: response.title || 'Success!',
                                text: response.message || 'Operation completed.',
                                timer: 2000,
                                showConfirmButton: false,
                            });

                            $('#basicModal').modal('hide');

                            $('.table.dataTable').each(function () {
                                $(this).DataTable().ajax.reload(null, false);
                            });

                            if (response.redirect) {
                                setTimeout(() => {
                                    window.location.href = response.redirect;
                                }, 2000);
                            }
                        }
                    },
                    error: function (xhr) {
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            for (let field in errors) {
                                const $input = $form.find(`[name="${field}"]`);
                                $input.addClass('is-invalid');
                                if ($input.next('.invalid-feedback').length === 0) {
                                    $input.after(`<div class="invalid-feedback">${errors[field][0]}</div>`);
                                }
                            }
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Something went wrong. Please try again.',
                            });
                        }
                    }
                });
            });
        });
    },

    bindDeleteHandler: function () {
        $(document).off('click', '[data-confirm-delete]').on('click', '[data-confirm-delete]', function (e) {
            e.preventDefault();

            const $btn = $(this);
            const url = $btn.attr('href');
            const title = $btn.data('confirm-title') || 'Are you sure?';
            const text = $btn.data('confirm-text') || 'This action cannot be undone.';

            Swal.fire({
                title: title,
                text: text,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        method: 'POST',
                        data: {
                            _method: 'DELETE',
                            _token: $('meta[name="csrf-token"]').attr('content'),
                        },
                        success: function (response) {
                            if (response.modal) {
                                Swal.fire({
                                    icon: response.type || 'success',
                                    title: response.title || 'Deleted!',
                                    text: response.message || 'Item successfully deleted.',
                                    timer: 2000,
                                    showConfirmButton: false,
                                });

                                $('.table.dataTable').each(function () {
                                    $(this).DataTable().ajax.reload(null, false);
                                });

                                if (response.redirect) {
                                    setTimeout(() => {
                                        window.location.href = response.redirect;
                                    }, 2000);
                                }
                            }
                        },
                        error: function () {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Failed to delete item. Please try again.',
                            });
                        }
                    });
                }
            });
        });
    },

    flatpickrDate: function (e) {
        var element = document.querySelector(e);
        if (element) {
            element.flatpickr({
                monthSelectorType: "static"
            });
        }
    },

    jqueryuiDate: function (e) {
        var element = document.querySelector(e);
        if (element) {
            e.datepicker();
        }
    },

    flatpickrTime: function (e) {
        var element = document.querySelector(e);
        if (element) {
            element.flatpickr({
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
            });
        }
    },

    summernote: function (e) {
        if ($(e).length) {
            $(e).summernote({
                height: "225"
            });
        } else {
            // console.error("Element does not exist or is null. Cannot initialize Summernote.");
        }
    },

    quill: function () {
        new Quill("#full-editor", {
            bounds: "#full-editor",
            placeholder: "Type Something...",
            modules: {
                formula: true,
                toolbar: [[{
                    font: []
                },
                    {
                        size: []
                    }], ["bold", "italic", "underline", "strike"], [{
                    color: []
                },
                    {
                        background: []
                    }], [{
                    script: "super"
                },
                    {
                        script: "sub"
                    }], [{
                    header: "1"
                },
                    {
                        header: "2"
                    },
                    "blockquote", "code-block"], [{
                    list: "ordered"
                },
                    {
                        list: "bullet"
                    },
                    {
                        indent: "-1"
                    },
                    {
                        indent: "+1"
                    }], [{
                    direction: "rtl"
                }], ["link", "image", "video", "formula"], ["clean"]]
            },
            theme: "snow"
        });
    },

    select2: function (select2) {
        $(select2).each(function() {
            const e = $(this);
            e.wrap('<div class="position-relative"></div>').select2({
                placeholder: "Select value",
                dropdownParent: e.parent()
            });
        });
    },

    editor: function (e) {
        new Quill(e, {
            bounds: e,
            placeholder: "Type Something...",
            modules: {
                formula: true,
                toolbar: [[{
                    font: []
                },
                    {
                        size: []
                    }], ["bold", "italic", "underline", "strike"], [{
                    color: []
                },
                    {
                        background: []
                    }], [{
                    script: "super"
                },
                    {
                        script: "sub"
                    }], [{
                    header: "1"
                },
                    {
                        header: "2"
                    },
                    "blockquote", "code-block"], [{
                    list: "ordered"
                },
                    {
                        list: "bullet"
                    },
                    {
                        indent: "-1"
                    },
                    {
                        indent: "+1"
                    }], [{
                    direction: "rtl"
                }], ["link", "image", "video", "formula"], ["clean"]]
            },
            theme: "snow"
        });
    },

    deleteConfirm: function(removeID) {
        Swal.fire({
            icon: 'warning',
            title: 'Delete this?',
            text: 'Are you sure you want to delete?',
            showCancelButton: true,
            confirmButtonText: 'Delete',
            confirmButtonColor: '#e3342f',
        }).then((result) => {
            if (result.isConfirmed === true) {
                document.getElementById(removeID).submit();
            }
        });
    },

    logoutConfirm: function(removeID) {
        Swal.fire({
            icon: 'warning',
            title: 'Logout',
            text: 'Are you sure you want to logout?',
            showCancelButton: true,
            confirmButtonText: 'Yes, Log Out',
            confirmButtonColor: '#e3342f',
        }).then((result) => {
            if (result.isConfirmed === true) {
                document.getElementById(removeID).submit();
            }
        });
    },

    datatable: function () {
        var options = {
            dom: '<"row me-0"<"col-md-2"<"me-3"l>><"col-md-10"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0"fB>>>t<"row mx-2"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            buttons: [{
                extend: "collection",
                className: "btn btn-label-secondary dropdown-toggle ms-3 waves-effect waves-light",
                text: '<i class="ti ti-screen-share me-1 ti-xs"></i>Export',
                buttons: [{
                    extend: "print",
                    text: '<i class="ti ti-printer me-2" ></i>Print',
                    className: "dropdown-item",
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5],
                        format: {
                            body: function(e, t, a) {
                                var s;
                                return e.length <= 0 ? e : (e = $.parseHTML(e), s = "", $.each(e, function(e, t) {
                                    void 0 !== t.classList && t.classList.contains("user-name") ? s += t.lastChild.firstChild.textContent : void 0 === t.innerText ? s += t.textContent : s += t.innerText
                                }), s)
                            }
                        }
                    },
                    customize: function(e) {
                        $(e.document.body).css("color", s).css("border-color", t).css("background-color", a), $(e.document.body).find("table").addClass("compact").css("color", "inherit").css("border-color", "inherit").css("background-color", "inherit")
                    }
                }, {
                    extend: "csv",
                    text: '<i class="ti ti-file-text me-2" ></i>Csv',
                    className: "dropdown-item",
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5],
                        format: {
                            body: function(e, t, a) {
                                var s;
                                return e.length <= 0 ? e : (e = $.parseHTML(e), s = "", $.each(e, function(e, t) {
                                    void 0 !== t.classList && t.classList.contains("user-name") ? s += t.lastChild.firstChild.textContent : void 0 === t.innerText ? s += t.textContent : s += t.innerText
                                }), s)
                            }
                        }
                    }
                }, {
                    extend: "excel",
                    text: '<i class="ti ti-file-spreadsheet me-2"></i>Excel',
                    className: "dropdown-item",
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5],
                        format: {
                            body: function(e, t, a) {
                                var s;
                                return e.length <= 0 ? e : (e = $.parseHTML(e), s = "", $.each(e, function(e, t) {
                                    void 0 !== t.classList && t.classList.contains("user-name") ? s += t.lastChild.firstChild.textContent : void 0 === t.innerText ? s += t.textContent : s += t.innerText
                                }), s)
                            }
                        }
                    }
                }, {
                    extend: "pdf",
                    text: '<i class="ti ti-file-code-2 me-2"></i>Pdf',
                    className: "dropdown-item",
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5],
                        format: {
                            body: function(e, t, a) {
                                var s;
                                return e.length <= 0 ? e : (e = $.parseHTML(e), s = "", $.each(e, function(e, t) {
                                    void 0 !== t.classList && t.classList.contains("user-name") ? s += t.lastChild.firstChild.textContent : void 0 === t.innerText ? s += t.textContent : s += t.innerText
                                }), s)
                            }
                        }
                    }
                }, {
                    extend: "copy",
                    text: '<i class="ti ti-copy me-2" ></i>Copy',
                    className: "dropdown-item",
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5],
                        format: {
                            body: function(e, t, a) {
                                var s;
                                return e.length <= 0 ? e : (e = $.parseHTML(e), s = "", $.each(e, function(e, t) {
                                    void 0 !== t.classList && t.classList.contains("user-name") ? s += t.lastChild.firstChild.textContent : void 0 === t.innerText ? s += t.textContent : s += t.innerText
                                }), s)
                            }
                        }
                    }
                }]
            }, {
                text: '<i class="ti ti-plus me-0 me-sm-1 ti-xs"></i><span class="d-none d-sm-inline-block">Add New User</span>',
                className: "add-new btn btn-primary waves-effect waves-light",
                attr: {
                    "data-bs-toggle": "offcanvas",
                    "data-bs-target": "#offcanvasAddUser"
                }
            }],
            responsive: true,
            colReorder: true,
            keys: true,
            rowReorder: true,
            select: true
        };

        if ($(window).width() <= 767) {
            options.rowReorder = false;
            options.colReorder = false;
        }

        $('.data-table').DataTable(options);
    },

    swiperQuery: function (swiperSlides) {
        var s = document.querySelector(swiperSlides);
        if (s) {
            new Swiper(s, {
                slidesPerView: 3,
                spaceBetween: 10,
                pagination: {
                    clickable: true,
                    el: ".swiper-pagination"
                }
            });
        }
    },

    setEqualHeight: function (elements) {
        var maxHeight = 0;

        if ($(elements).length) {
            // Loop through each element to find the maximum height
            elements.each(function() {
                var currentHeight = $(this).height();
                if (currentHeight > maxHeight) {
                    maxHeight = currentHeight;
                }
            });

            // Set the maximum height to all div elements
            elements.height(maxHeight);
        }
    },

    socialMedia: function () {
        // Function to generate a new social link input group
        function generateSocialLinkInput(index) {
            return `
                    <div class="input-group mb-2">
                        <select name="social_link[platform][${index}]" class="form-select">
                            <option selected>Choose...</option>
                            <option value="Facebook">Facebook</option>
                            <option value="Instagram">Instagram</option>
                            <option value="Pinterest">Pinterest</option>
                            <option value="LinkedIn">LinkedIn</option>
                            <option value="YouTube">YouTube</option>
                            <option value="Reddit">Reddit</option>
                            <option value="Snapchat">Snapchat</option>
                            <option value="TikTok">TikTok</option>
                            <option value="WhatsApp">WhatsApp</option>
                            <option value="Telegram">Telegram</option>
                            <option value="LINE">LINE</option>
                            <option value="X">X</option>
                        </select>
                        <input name="social_link[url][${index}]" type="text" class="form-control w-50">
                        <button class="btn btn-danger btn-icon remove-field-button" type="button"><i class="ti ti-trash"></i></button>
                    </div>
                `;
        }

        // Initial index for new input groups
        let index = 1;

        // Event listener for adding a new input group
        $('.social-links-container').on('click', '.add-field-button', function() {
            const newInputGroup = generateSocialLinkInput(index);
            $('.social-links-container').append(newInputGroup);
            index++;
        });

        // Event listener for removing an input group
        $('.social-links-container').on('click', '.remove-field-button', function() {
            $(this).closest('.input-group').remove();
        });
    },

    btnPublishBtn: function () {
        let currentStatus = $("#publish-status").val(); // Get the stored value

        let colorClass = {
            "Draft": "btn-warning",
            "Active": "btn-success",
            "Inactive": "btn-secondary"
        };

        let btnGroup = $(".btn-publish-set .btn-group .btn");

        btnGroup.removeClass("btn-primary btn-warning btn-success btn-secondary")
            .addClass(colorClass[currentStatus] || "btn-primary");

        $(".btn-publish-set .btn:first-child").text(currentStatus);

        $(".btn-publish-set .dropdown-menu .dropdown-item").click(function (e) {
            e.preventDefault();
            let selectedText = $(this).text();
            btnGroup.removeClass("btn-primary btn-warning btn-success btn-secondary")
                .addClass(colorClass[selectedText] || "btn-primary");
            $(".btn-publish-set .btn:first-child").text(selectedText);
            $("#publish-status").val(selectedText);
        });
    },

    btnSubmissionBtn: function () {
        let currentStatus = $("#submission-status").val(); // Get the stored value

        let colorClass = {
            "Pending": "btn-warning",
            "Approved": "btn-success",
            "Rejected": "btn-danger",
            "Archived": "btn-secondary",
        };

        let btnGroup = $(".btn-submission-set .btn-group .btn");

        btnGroup.removeClass("btn-warning btn-success btn-danger btn-secondary")
            .addClass(colorClass[currentStatus] || "btn-primary");

        $(".btn-submission-set .btn:first-child").text(currentStatus);

        $(".btn-submission-set .dropdown-menu .dropdown-item").click(function (e) {
            e.preventDefault();
            let selectedText = $(this).text();
            btnGroup.removeClass("btn-warning btn-success btn-danger btn-secondary")
                .addClass(colorClass[selectedText] || "btn-primary");
            $(".btn-submission-set .btn:first-child").text(selectedText);
            $("#submission-status").val(selectedText);
        });
    },

    ajaxSetup: function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    },

    ajaxDocumentToken: function () {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $('form[method]').each(function() {
            var $form = $(this);
            var method = ($form.attr('method') || '').toLowerCase();
            if (method === 'post' && $form.find('input[name="_token"]').length === 0) {
                $form.prepend('<input type="hidden" name="_token" value="' + csrfToken + '">');
            }
        });
    },
    addToCartShortCut: function (selector) {
        $(selector).each(function(){
            var $form = $(this);
            var basePrice = parseFloat($form.find('input[name="base-price"]').val());
            var additionalTotal = 0;

            $form.find('input[type="radio"]:checked').each(function(){
                var addPrice = parseFloat($(this).data('additional-price')) || 0;
                additionalTotal += addPrice;
            });

            var finalPrice = basePrice + additionalTotal;
            finalPrice = finalPrice * (1 + COMMISSION_RATE / 100);

            $form.find('input[name="price"]').val(finalPrice.toFixed(2));
        });
    },

    addToWishlist: function (selector) {
        $(selector).each(function () {

        });
    }
};

$(document).ready(function () {
    Apps.init();
});
