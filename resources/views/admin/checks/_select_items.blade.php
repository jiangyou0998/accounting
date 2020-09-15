var item_id = "item_" + 842 ;
var item = document.getElementById(item_id);
if (item != null) {
addToItemList(document.getElementById(item_id), 1);
$("#" + item_id).addClass("item_selected");
}
