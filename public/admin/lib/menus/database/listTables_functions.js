
$(document).ready(function(){ init(); });


//
function init() {
  initSortable(null, updateTableOrder);
}

//
function updateTableOrder(row, table){	
      // get new order
      var rows       = table.tBodies[0].rows;
      var tableNames = '';
      for (var i=0; i<rows.length; i++) {
          var thisName = $("._tableName", rows[i]).val();
          if (thisName) {
            if (tableNames != '') { tableNames += ','; }
            tableNames += thisName;
          }
      }
     
  redirectWithPost('?', {
    'menu':       'database',
    'action':     'listTables',
    'newOrder':       tableNames,
    '_CSRFToken': $('[name=_CSRFToken]').val()
  });

}

//
function confirmEraseTable(tableName) {

  var isConfirmed = confirm("Delete this menu?\n\nWARNING: All data will be lost!\n ");
  if (isConfirmed) {
//    window.location="?menu=database&action=editTable&dropTable=1&tableName=" + tableName;
    redirectWithPost('?', {
      'menu':       'database',
      'action':     'editTable',
      'dropTable':  '1',
      'tableName':  tableName,
      '_CSRFToken': $('[name=_CSRFToken]').val()
    });
    
  }
}

//
function addNewMenu(tablename, fieldname) {

  // set iframe height
  var iframeHeight = 475;
  var windowHeight = document.documentElement.clientHeight;
  if (windowHeight < 200) { iframeHeight = 200; }

  // get url
  var url = "?menu=database&action=addTable"
          + "&TB_iframe=true&width=700&height=" + iframeHeight
          + "&width=" + 625
          + "&modal=true";

  // show thickbox
  var caption    = null;
  var imageGroup = false;
  tb_show(caption, url, imageGroup);
}
