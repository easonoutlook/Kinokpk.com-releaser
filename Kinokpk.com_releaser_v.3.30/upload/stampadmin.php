<?php
/**
 * Stamp administration
 * @license GNU GPLv3 http://opensource.org/licenses/gpl-3.0.html
 * @package Kinokpk.com releaser
 * @author ZonD80 <admin@kinokpk.com>
 * @copyright (C) 2008-now, ZonD80, Germany, TorrentsBook.com
 * @link http://dev.kinokpk.com
 */

require_once "include/bittorrent.php";

function bark($msg) {
	global $REL_LANG;
	stderr($REL_LANG->say_by_key('error'), $msg);
}

dbconn();
loggedinorreturn();
httpauth();

if (get_user_class() < UC_SYSOP) bark("Access denied. You're not SYSOP.");
if (!isset($_GET['action'])) {
	$REL_TPL->stdhead("������� ������� � �������");
	print("<div algin=\"center\"><h1>������� �������</h1></div>");
	print("<table width=\"100%\" border=\"0\"><tr><td><a href=\"".$REL_SEO->make_link('stampadmin','action','add')."\">�������� �����</a></td></tr></table>");
	$stamparray = sql_query("SELECT * FROM stamps ORDER BY id ASC");
	print("<form name=\"saveids\" action=\"".$REL_SEO->make_link('stampadmin','action','saveids')."\" method=\"post\"><table width=\"100%\" border=\"1\"><tr><td class=\"colhead\">ID</td><td class=\"colhead\">��������</td><td class=\"colhead\">�������</td><td class=\"colhead\">����� �������</td><td class=\"colhead\">���/��</td></tr>");
	while($stamp = mysql_fetch_array($stamparray)) {
		print("<tr><td>".$stamp['id']."</td><td><img src=\"pic/stamp/".$stamp['image']."\"></td><td><input type=\"text\" name=\"sort[".$stamp['id']."]\" size=\"4\" value=\"".$stamp['sort']."\"></td><td>".get_user_class_name($stamp['class'])."</td><td><a href=\"".$REL_SEO->make_link('stampadmin','action','edit','id',$stamp['id'])."\">E</a> | <a onClick=\"return confirm('�� �������?')\" href=\"".$REL_SEO->make_link('stampadmin','action','delete','id',$stamp['id'])."\">D</a></td></tr>");
	}
	print("</table><input type=\"submit\" class=\"btn\" value=\"��������� ������� �����������\"></form>");
	$REL_TPL->stdfoot();
}

elseif ($_GET['action'] == 'saveids') {

	if (is_array($_POST['sort'])) {

		foreach ($_POST['sort'] as $id => $s) {

			sql_query("UPDATE stamps SET sort = ".intval($s)."  WHERE id = " . $id);
		}
		safe_redirect($REL_SEO->make_link('stampadmin'));
		exit();
	}
	else bark("Missing form data");
}

elseif ($_GET['action'] == 'add') {
	$REL_TPL->stdhead("���������� ������");
	print("<form action=\"".$REL_SEO->make_link('stampadmin','action','saveadd')."\" name=\"savearray\" method=\"post\"><table width=\"100%\"><tr><td class=\"colhead\">�������� (��� �����)</td></tr><tr><td><input type=\"text\" name=\"image\" size=\"80\"></td></tr><tr><td class=\"colhead\">���������� (������� ���������)</td></tr><tr><td><input type=\"text\" name=\"sort\" size=\"4\"></td></tr><tr><td class=\"colhead\">����� �������</td></tr><tr><td>
  <select size=\"1\" name=\"class\">
<option value=\"6\">������ ����������</option>
<option value=\"5\">�������������� � ����</option>
<option value=\"4\">���������� � ����</option>
<option value=\"3\">��������� � ����</option>
<option value=\"2\">VIP'� � ����</option>
<option value=\"1\">����������� � ����</option>
<option value=\"0\">������������ � ����</option>
</select></td></tr><tr><td><input type=\"submit\" class=\"btn\" value=\"��������\"></td></tr></table></form>");
	$REL_TPL->stdfoot();
}

elseif ($_GET['action'] == 'delete') {
	if ((!isset($_GET['id'])) || ($_GET['id'] == "") || (!is_numeric($_GET['id']))) bark("Wrong ID");
	sql_query("DELETE FROM stamps WHERE id = ".$_GET['id']);
	safe_redirect($REL_SEO->make_link('stampadmin'));
	exit();

}

elseif ($_GET['action'] == 'edit') {
	if ((!isset($_GET['id'])) || ($_GET['id'] == "") || (!is_numeric($_GET['id']))) bark("Wrong ID");

	$stamparray = sql_query("SELECT * FROM stamps WHERE id=".$_GET['id']);
	list($id,$sort,$class,$image) = mysql_fetch_array($stamparray);

	$REL_TPL->stdhead("�������������� ������");
	print("<form name=\"save\" action=\"".$REL_SEO->make_link('stampadmin','action','saveedit')."\" method=\"post\"><table width=\"100%\"><tr><td class=\"colhead\">�������� (��� �����)</td></tr><tr><td><input type=\"hidden\" name=\"id\" value=\"".$id."\"><input type=\"text\" name=\"image\" size=\"80\" value=\"".$image."\"></td></tr><tr><td class=\"colhead\">���������� (������� ���������)</td></tr><tr><td><input type=\"text\" name=\"sort\" size=\"4\" value=\"".$sort."\"></td></tr><tr><td class=\"colhead\">����� �������</td></tr><tr><td>
<select size=\"1\" name=\"class\">
<option ".($class == "6" ? "selected" : "")." value=\"6\">������ ����������</option>
<option ".($class == "5" ? "selected" : "")." value=\"5\">�������������� � ����</option>
<option ".($class == "4" ? "selected" : "")." value=\"4\">���������� � ����</option>
<option ".($class == "3" ? "selected" : "")." value=\"3\">��������� � ����</option>
<option ".($class == "2" ? "selected" : "")." value=\"2\">VIP'� � ����</option>
<option ".($class == "1" ? "selected" : "")." value=\"1\">����������� � ����</option>
<option ".($class == "0" ? "selected" : "")." value=\"0\">������������ � ����</option>
</select></td></tr><tr><td><input type=\"submit\" class=\"btn\" value=\"���������������\"></td></tr></table></form>");
	$REL_TPL->stdfoot();
}

elseif ($_GET['action'] == 'saveedit') {
	sql_query("UPDATE stamps SET image=".sqlesc(htmlspecialchars((string)$_POST['image'])).",sort=".intval($_POST['sort']).",class=".intval($_POST['class'])." WHERE id=".intval($_POST['id']));
	safe_redirect($REL_SEO->make_link('stampadmin'));
	exit();
}
elseif ($_GET['action'] == 'saveadd') {

	sql_query("INSERT INTO stamps (image,sort,class) VALUES (".sqlesc(htmlspecialchars((string)$_POST['image'])).",".intval($_POST['sort']).",".intval($_POST['class']).")");
	safe_redirect($REL_SEO->make_link('stampadmin'));
	exit();
}


