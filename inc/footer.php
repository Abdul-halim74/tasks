<script>


 $(document).ready(function () {

     if ($(window).width() < '768'){
         $('.linebar').addClass('nospace');
         $('#sidebar').addClass('hide-sidebar');
         $('.content-area').addClass('expand')
    }else{
         $('.linebar').removeClass('nospace');
         $('#sidebar').removeClass('hide-sidebar');
         $('.content-area').removeClass('expand')
    }
  
 //toogle  show  hide sidebar
 
 $(".linebar").click(function(){  
     $('.linebar i').toggleClass('fa-angle-double-right fa-angle-double-left') 
     $('.linebar').toggleClass('nospace') 
     $('#sidebar').toggleClass('hide-sidebar');
     $('.content-area').toggleClass('expand');
     
    });  
    
});



    $('.daterange').daterangepicker();
    $(document).ready(function () {
 $('.summernote-sm').summernote({
            height: 150,                 // set editor height
            minHeight: null,             // set minimum height of editor
            maxHeight: null,             // set maximum height of editor
            focus: false                 // set focus to editable area after initializing summernote
        });
        $('.summernote').summernote({
            height: 250,                 // set editor height
            minHeight: null,             // set minimum height of editor
            maxHeight: null,             // set maximum height of editor
            focus: false                 // set focus to editable area after initializing summernote
        });
        $('.summernote_read_only').summernote({
            height: 250,                 // set editor height
            minHeight: null,             // set minimum height of editor
            maxHeight: null,             // set maximum height of editor
            focus: false                 // set focus to editable area after initializing summernote
        });
        $(".summernote_read_only").summernote("disable");
    });
</script>
<script>
    $(document).ready(function () {
        // Setup - add a text input to each footer cell
        $('#example thead tr').clone(true).appendTo('#example thead');
        $('#example thead tr:eq(1) th').each(function (i) {
            var title = $(this).text();
            //$(this).html( '<input type="text" placeholder="Search '+title+'" />' );
            $(this).html('<input type="text" placeholder=" " />');

            $('input', this).on('keyup change', function () {
                if (table.column(i).search() !== this.value) {
                    table
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });
        });

        var table = $('#example').DataTable({
            orderCellsTop: true,
            fixedHeader: true,
            "autoWidth": false,
            //"scrollX": true,
            "aaSorting": []
        });
    });
</script>
<script>
    $('.datepicker').datepicker({
        format: "d-m-yyyy",
        startDate: "-0d"
    });

     $('.datepicker_open_off').datepicker({
        format: "yyyy-m-d",
        startDate: "-0d"
    });

       $('.simple-datepicker').datepicker({
        format: "d-m-yyyy",
    });

    $('.simple-datepicker').datepicker({
        format: "d-m-yyyy",

    });

    //for  current date  in  input  field .datepicker("setDate", "0")

    $(".smenu").click(function () {
        $(this).find(".subs").slideToggle();
    });

    $(function() {
  $('.selectpicker').selectpicker();
});

    
</script>
