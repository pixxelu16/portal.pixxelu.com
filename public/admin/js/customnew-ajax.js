//search customer through keyup filter
$(document).ready(function () {
    $('#customer_name').on('keyup', function () {
        var query = $(this).val();
        $('html, body').animate({ scrollTop: 0 }, 300, function () {
            //ajax Call
            $.ajax({
                url: base_url + '/super-admin/search-employees',
                method: 'GET',
                data: { customer_name: query },
                beforeSend: function () {
                    $('#overlayBlur').addClass('active');
                    $('#topLoaderBar').css({
                        display: 'block',
                        width: '0%',
                        transition: 'width 1s ease-in-out'
                    });
                    setTimeout(() => {
                        $('#topLoaderBar').css('width', '100%');
                    }, 50);
                },
                success: function (response) {
                    $('#fullList').hide();
                    $('#result').html(response).show();
                    bindActionButtons();                    
                },
                complete: function () {
                    setTimeout(() => {
                        $('#overlayBlur').removeClass('active');
                        $('#topLoaderBar').css({
                            width: '0%',
                            display: 'none'  
                        });
                    }, 1000);
                },
                error: function () {
                    $('#result').html('<div class="text-danger">Error occurred</div>').show();
                }
            });
        });
    });

    //handle add new card click on the customer search page
    $(document).on('click', '#addNewCard', function () {
        var link = $(this).data('link');
        //overlayblur and  toploader
        $('html, body').animate({ scrollTop: 0 }, 300, function () {
            $('#overlayBlur').addClass('active');
            $('#topLoaderBar').css({
                display: 'block',
                width: '0%',
                transition: 'width 1s ease-in-out'
            });
            setTimeout(() => {
                $('#topLoaderBar').css('width', '100%');
            }, 50);
            setTimeout(() => {
                $('#topLoaderBar').css({
                    width: '0%',
                    display: 'none' 
                });
                $('#overlayBlur').removeClass('active');
                window.location.href = link;
            }, 1400);
        });
    });

    //search job letter page
     $('#customer_names').on('keyup', function () {
        let query = $(this).val().trim();
        if (query.length >= 2) {
            //ajax call
            $.ajax({
                type: 'GET',
                url: base_url + '/super-admin/search-employee-name',
                data: { customer_names: query },
                beforeSend: function () {
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                    $('#overlayBlur').addClass('active');
                    $('#topLoaderBar').css({
                        display: 'block',
                        width: '0%',
                        transition: 'width 1s ease-in-out'
                    });

                    setTimeout(() => {
                        $('#topLoaderBar').css('width', '100%');
                    }, 50);
                },
                success: function (res) {
                    if (!isNaN(res)) {
                        setTimeout(() => {
                            window.location.href = base_url + "/super-admin/job-letter/" + res;
                        }, 1000);
                    } else {
                        $('#resultContainer').html(res);
                    }
                },
                complete: function () {
                    setTimeout(() => {
                        $('#overlayBlur').removeClass('active');
                        $('#topLoaderBar').css({
                            width: '0%',
                            display: 'none'
                        });
                    }, 1200);
                },
                error: function () {
                    console.error("Something went wrong.");
                }
            });
        }
    });

    //Delete customer record
    $('body').on('click', '.is_delete_customer_record', function(event) {
        event.preventDefault();
        var employee_id = $(this).data('employee_id');
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, Delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'GET',
                    url: base_url + '/super-admin/delete-employee',
                    data: { employee_id: employee_id },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        Swal.fire({
                            title: "Deleted!",
                            html: '<div class="custom-swal-text-red">Employee record deleted successfully.</div>',
                            icon: "success",
                            showConfirmButton: false,
                            timer: 1800,
                            timerProgressBar: true,
                            width: '400px',
                            hieght: '400px',
                            customClass: {
                                popup: 'custom-swal-popup',
                                title: 'custom-swal-title',
                                content: 'custom-swal-text'
                            }
                        }).then(() => {
                            const overlay = document.getElementById('overlayBlur');
                            const loaderBar = document.getElementById('topLoaderBar');

                            if (overlay) overlay.classList.add('active');

                            if (loaderBar) {
                                loaderBar.style.display = 'block';
                                loaderBar.style.width = '0%';
                                loaderBar.style.transition = 'width 1.5s ease-in-out';
                                setTimeout(() => {
                                    loaderBar.style.width = '100%';
                                }, 50);
                            }
                            window.scrollTo({ top: 0, behavior: 'smooth' });
                            setTimeout(() => {
                                location.reload();
                            }, 1800);
                        });
                    },
                });
            }
        });
    });
});
