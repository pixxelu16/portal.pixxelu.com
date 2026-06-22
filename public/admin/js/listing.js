function moveAttendanceDtChrome($table) {
    var $wrapper = $table.closest('.dataTables_wrapper');
    var $listing = $table.closest('.portal-attendance-listing');
    var $scroll = $table.closest('.portal-attendance-scroll');
    if (!$listing.length || !$scroll.length || !$wrapper.length) return;

    var $toolbar = $wrapper.children('.portal-dt-toolbar').detach();
    var $footer = $wrapper.children('.portal-dt-footer').detach();
    if ($toolbar.length) $scroll.before($toolbar);
    if ($footer.length) $listing.append($footer);
}

function initPortalListing(tableId, options) {
    tableId = tableId || 'portalListingTable';
    var $table = $('#' + tableId);
    if (!$table.length || !$.fn.DataTable) return null;

    if ($.fn.DataTable.isDataTable($table)) {
        $table.DataTable().destroy();
    }

    var defaults = {
        pageLength: 20,
        lengthChange: false,
        order: [],
        language: { search: '', searchPlaceholder: 'Search records...' },
        dom: '<"portal-dt-toolbar"f>rt<"portal-dt-footer"ip>'
    };

    return $table.DataTable($.extend(true, {}, defaults, options || {}));
}

function initPortalAttendanceTable(tableId) {
    tableId = tableId || 'example10';
    var $table = $('#' + tableId);
    if (!$table.length || !$.fn.DataTable) return null;

    if ($.fn.DataTable.isDataTable($table)) {
        $table.DataTable().destroy();
    }

    return $table.DataTable({
        pageLength: 10,
        lengthMenu: [[10, 20, 50, 100, -1], [10, 20, 50, 100, 'All']],
        order: [],
        ordering: false,
        language: {
            search: '',
            searchPlaceholder: 'Search by name or ID...',
            lengthMenu: 'Show _MENU_ entries',
            info: 'Showing _START_ to _END_ of _TOTAL_ entries',
            paginate: { previous: 'Previous', next: 'Next' }
        },
        dom: '<"portal-dt-toolbar"lf>rt<"portal-dt-footer"ip>',
        initComplete: function () {
            moveAttendanceDtChrome($table);
        }
    });
}

$(document).ready(function () {
    if ($('#portalListingTable').length) {
        initPortalListing('portalListingTable');
    }
    if ($('#example10').length) {
        initPortalAttendanceTable('example10');
    }
});
