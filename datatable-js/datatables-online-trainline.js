var TableDatatablesManaged = function () {
  var getUrlParam = function(name) {
                  var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)"); //构造一个含有目标参数的正则表达式对象
                              var r = window.location.search.substr(1).match(reg);  //匹配目标参数
                                          if (r != null) return unescape(r[2]); return null; //返回参数值
                                                  }
    var initTable = function () {

        var table = $('#online_datatables_trainlines');
        var myUrl = '/backend/index.php/online/trainlinesapi?from='+getUrlParam('from')+'&to='+getUrlParam('to');

        // begin first table
        table.dataTable({

            // Internationalisation. For more info refer to http://datatables.net/manual/i18n
            "language": {
                "aria": {
                    "sortAscending": ": activate to sort column ascending",
                    "sortDescending": ": activate to sort column descending"
                },
                "emptyTable": "No data available in table",
                "info": "Showing _START_ to _END_ of _TOTAL_ records",
                "infoEmpty": "No records found",
                "infoFiltered": "(filtered1 from _MAX_ total records)",
                "lengthMenu": "Show _MENU_",
                "search": "Search:",
                "zeroRecords": "No matching records found",
                "paginate": {
                    "previous":"Prev",
                    "next": "Next",
                    "last": "Last",
                    "first": "First"
                }
            },

            // Or you can use remote translation file
            //"language": {
            //   url: '//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Portuguese.json'
            //},

            // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
            // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js). 
            // So when dropdowns used the scrollable div should be removed. 
            //"dom": "<'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",

           // "bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.
/*
            "columnDefs": [ {
                "targets": 0,
                "orderable": false,
                "searchable": false
            }],
*/
            serverSide: true,
            
            ajax: {
                    url: myUrl,
                    type: 'GET',
            },
            "columns" : [
                    {"data" : "fromname" },
                    {"data" : "toname" },
                    {"data" : "middlename" },
                    {"data" : "startTime_start" },
                    {"data" : "endTime_start" },
                    {"data" : "trainno_start" },
                    {"data" : "startTime_middle" },
                    {"data" : "endTime_middle" },
                    {"data" : "trainno_middle" },
                ],
            "lengthMenu": [
                [5, 15, 20, -1],
                [5, 15, 20, "All"] // change per page values here
            ],
            // set the initial value
            "pageLength": 20,            
            "pagingType": "bootstrap_full_number",
            /*
            "columnDefs": [{  // set default column settings
                'orderable': false,
               'targets': [0]
           }, {
               "searchable": false,
               "targets": [0]
           }],
           */
            "order": [
                [0, "asc"]
            ] // set first column as a default sort by asc
        });

        var tableWrapper = jQuery('#sample_1_wrapper');
        /*
        table.find('.group-checkable').change(function () {
            var set = jQuery(this).attr("data-set");
            var checked = jQuery(this).is(":checked");
            jQuery(set).each(function () {
                if (checked) {
                    $(this).prop("checked", true);
                    $(this).parents('tr').addClass("active");
                } else {
                    $(this).prop("checked", false);
                    $(this).parents('tr').removeClass("active");
                }
            });
            jQuery.uniform.update(set);
        });

        table.on('change', 'tbody tr .checkboxes', function () {
            $(this).parents('tr').toggleClass("active");
        });
        */
    }
    return {
        //main function to initiate the module
        init: function () {
            if (!jQuery().dataTable) {
                return;
            }
            initTable();
        }

    };

}();
if (App.isAngularJsApp() === false) { 
    jQuery(document).ready(function() {
        TableDatatablesManaged.init();
    });
}
