<?php
require_once("include/bittorrent.php");

if (!isset($_GET['step'])) {
print "��� ������������ ������ �������� TBDEV YSE 6 �� Kinokpk.com releaser 2.40. �������� ����������� � ��� ����� ���������.<br/>
������� ������� ����� �� <a href=\"http://dev.kinokpk.com/viewtopic.php?t=39\">����� ������</a> �� ������ ���������� ��������.<br/>
���� �� ������ ��������� ������� �������, �� ��� �������� ������� � ���� ������� ��������� \$descr_typeid (ID ������ �������) � descr_type (ID �������) (� SQL �������) � ������������ � ����� ���������������.<br/>
��������� ��� ������� ��.<hr/>";
print "Greetings for you from TBDEV YSE 6 to Kinokpk.com releaser 2.40 transfer script. Follow the instructions and all will be OK.<br/>
Releases' templates are taken from <a href=\"http://dev.kinokpk.com/viewtopic.php?t=39\">This thread</a> of developer's forum.<br/>
If you want to change default parametres, you shall edit \$descr_typeid (ID template's detail) and descr_type (ID of template) (in SQL query) according to your editing.<br/>
Next step will update database.<hr/>";

print '<a href="transfer.php?step=1">����������/Continue</a>';

}

elseif ($_GET['step'] ==1) {

      print('<hr/>������ ���� ������ / Updating database: ');
  relconn();
  $strings = file("update.sql");
$query = '';
foreach ($strings AS $string)
{
  if (preg_match("/^\s?#/", $string) || !preg_match("/[^\s]/", $string))
     continue;
  else
  {
      $query .= $string;
      if (preg_match("/;\s?$/", $query))
      {
           mysql_query($query) or die('<font color="red">FAIL</font>, ������ MySQL / MySQL error ['.mysql_errno().']: ' . mysql_error());
           $query = '';
      }
  }
}
 print('<font color="green">OK</font><hr/>');
 
print "���� ������� ���������, ��������� ��� �������� ������������ � ��������� �������� �������<hr/>";
print "Your database was successfully updated, next step will execute main configuration script and transfer releases' descriptions<hr/>";
print '<a href="transfer.php?step=2">����������/Continue</a>';
}

elseif ($_GET['step'] ==2) {
dbconn();
if (!isset($_GET['action'])){


print("�������� ��������� Kinokpk.com releaser ".RELVERSION."<hr/>");
print('<table width="100%" border="1">');
print('<form action="transfer.php?action=save&step=2" method="POST">');
print('<tr><td align="center" colspan="2" class="colhead">�������� ���������</td></tr>');

print('<tr><td>����� ����� (��� /):</td><td><input type="text" name="defaultbaseurl" size="30" value="'.$CACHEARRAY['defaultbaseurl'].'"> ��������, "http://www.kinokpk.com"</td></tr>');
print('<tr><td>�������� ����� (title):</td><td><input type="text" name="sitename" size="80" value="'.$CACHEARRAY['sitename'].'"> ��������, "������� �������� �����������"</td></tr>');
print('<tr><td>�������� ����� (meta description):</td><td><input type="text" name="description" size="80" value="'.$CACHEARRAY['description'].'"> ��������, "����� ������� ���������� ������� ����"</td></tr>');
print('<tr><td>�������� ����� (meta keywords):</td><td><input type="text" name="keywords" size="80" value="'.$CACHEARRAY['keywords'].'"> ��������, "�������, ����������, ������, �������"</td></tr>');
print('<tr><td>�����, � �������� ����� ������������ ��������� �����:</td><td><input type="text" name="siteemail" size="30" value="'.$CACHEARRAY['siteemail'].'"> ��������, "bot@kinokpk.com"</td></tr>');
print('<tr><td>����� ��� ����� � ���������������:</td><td><input type="text" name="adminemail" size="30" value="'.$CACHEARRAY['adminemail'].'"> ��������, "admin@windows.lox"</td></tr>');
print('<tr><td>���� �������� �� ��������� (��� lang_%����%):</td><td><input type="text" name="default_language" size="10" value="'.$CACHEARRAY['default_language'].'"></td></tr>');
print('<tr><td>������������ ������� �������������� (��������� �� �������������):</td><td><select name="use_lang"><option value="1" '.($CACHEARRAY['use_lang']==1?"selected":"").'>��</option><option value="0" '.($CACHEARRAY['use_lang']==0?"selected":"").'>���</option></select></td></tr>');
print('<tr><td>����������� ���� ��� ������ � ���������������� (themes/%����%):</td><td><input type="text" name="default_theme" size="10" value="'.$CACHEARRAY['default_theme'].'"> �� ��������� "kinokpk"</td></tr>');
print('<tr><td>��� �������� ��� ����������� ����� ��������:<br/><small>*�� ������ ������������ ������ <b>{datenow}</b> ��� ������ �������� ����</small></td><td><input type="text" name="yourcopy" size="60" value="'.$CACHEARRAY['yourcopy'].'"> ��������, "&copy; 2008-{datenow} ��� ����"</td></tr>');
print('<tr><td>����� �� ����������� ���������:</td><td><input type="text" name="watermark" size="60" value="'.$CACHEARRAY['watermark'].'"> ��������, "Kinokpk.com releaser"</td></tr>');
print('<tr><td>������������ ������� ������ (��������� �� �������������):</td><td><select name="use_blocks"><option value="1" '.($CACHEARRAY['use_blocks']==1?"selected":"").'>��</option><option value="0" '.($CACHEARRAY['use_blocks']==0?"selected":"").'>���</option></select></td></tr>');
print('<tr><td>������������ gzip ������ ��� �������:</td><td><select name="use_gzip"><option value="1" '.($CACHEARRAY['use_gzip']==1?"selected":"").'>��</option><option value="0" '.($CACHEARRAY['use_gzip']==0?"selected":"").'>���</option></select></td></tr>');
print('<tr><td>������������ ������� ����� �� IP/��������:</td><td><select name="use_ipbans"><option value="1" '.($CACHEARRAY['use_ipbans']==1?"selected":"").'>��</option><option value="0" '.($CACHEARRAY['use_ipbans']==0?"selected":"").'>���</option></select></td></tr>');
print('<tr><td>������������ ������:</td><td><select name="use_sessions"><option value="1" '.($CACHEARRAY['use_sessions']==1?"selected":"").'>��</option><option value="0" '.($CACHEARRAY['use_sessions']==0?"selected":"").'>���</option></select></td></tr>');
print('<tr><td>��� SMTP:</td><td><input type="text" name="smtptype" size="10" value="'.$CACHEARRAY['smtptype'].'"></td></tr>');

print('<tr><td align="center" colspan="2" class="colhead">��������� ���������� � ������� IPB</td></tr>');

print('<tr><td>������������ ���������� � ������� IPB:</td><td><select name="use_integration"><option value="1" '.($CACHEARRAY['use_integration']==1?"selected":"").'>��</option><option value="0" '.($CACHEARRAY['use_integration']==0?"selected":"").'>���</option></select></td></tr>');
print('<tr><td>��� �������� ������� �� �����:<br/><small>*��� ������������� ������� �������� � ����-������<br/>���������� ���������� IPB � wikimedia � <a target="_blank" href="http://www.ipbwiki.com/">http://www.ipbwiki.com/</a></small></td><td><select name="exporttype"><option value="wiki" '.($CACHEARRAY['exporttype']=="wiki"?"selected":"").'>� ����-������</option><option value="post" '.($CACHEARRAY['exporttype']=="post"?"selected":"").'>��������������� � ����</option></select></td></tr>');
print('<tr><td>����� ������ (��� /):</td><td><input type="text" name="forumurl" size="60" value="'.$CACHEARRAY['forumurl'].'"> ��������, "http://forum.pdaprime.ru"</td></tr>');
print('<tr><td>������� ������:</td><td><input type="text" name="forumname" size="60" value="'.$CACHEARRAY['forumname'].'"> ��������, "pdaPRIME.ru"</td></tr>');
print('<tr><td>������� �������� cookie:</td><td><input type="text" name="ipb_cookie_prefix" size="4" value="'.$CACHEARRAY['ipb_cookie_prefix'].'"> �� ��������� IPB, �����</td></tr>');
print('<tr><td>ID ������-�������:</td><td><input type="text" name="forum_bin_id" size="3" value="'.$CACHEARRAY['forum_bin_id'].'"></td></tr>');
print('<tr><td>����� ������������� ����� �������� �� �����:</td><td><input type="text" name="defuserclass" size="1" value="'.$CACHEARRAY['defuserclass'].'"> �� ��������� IPB, "3"</td></tr>');
print('<tr><td>ID ������ ��� �������� ������ �������:<br/><small>*��� ������, ����� ������� �� ��������� � ��������� �����, ���� �������� ������ ��� ����������� ������</small></td><td><input type="text" name="not_found_export_id" size="3" value="'.$CACHEARRAY['not_found_export_id'].'"></td></tr>');
print('<tr><td>����� �� �������� ������ (��� /):</td><td><input type="text" name="emo_dir" size="10" value="'.$CACHEARRAY['emo_dir'].'"> �� ��������� IPB, "default"</td></tr>');


print('<tr><td align="center" colspan="2" class="colhead">��������� �����������</td></tr>');

print('<tr><td>��������� �����������:</td><td><select name="deny_signup"><option value="1" '.($CACHEARRAY['deny_signup']==1?"selected":"").'>��</option><option value="0" '.($CACHEARRAY['deny_signup']==0?"selected":"").'>���</option></select></td></tr>');
print('<tr><td>��������� ����������� �� ������������:</td><td><select name="allow_invite_signup"><option value="1" '.($CACHEARRAY['allow_invite_signup']==1?"selected":"").'>��</option><option value="0" '.($CACHEARRAY['allow_invite_signup']==0?"selected":"").'>���</option></select></td></tr>');
print('<tr><td>������������ ��������� ��������� �� e-mail:</td><td><select name="use_email_act"><option value="1" '.($CACHEARRAY['use_email_act']==1?"selected":"").'>��</option><option value="0" '.($CACHEARRAY['use_email_act']==0?"selected":"").'>���</option></select></td></tr>');
print('<tr><td>������������ �����:<br/><small>*�� ������ ������������������ �� <a target="_blank" href="http://recaptcha.net">ReCaptcha.net</a> � �������� ��������� � ��������� ����� ��� ������������� ���� �����</small></td><td><select name="use_captcha"><option  value="1" '.($CACHEARRAY['use_captcha']==1?"selected":"").'>��</option><option value="0" '.($CACHEARRAY['use_captcha']==0?"selected":"").'>���</option></select></td></tr>');
print('<tr><td>��������� ���� �����:</td><td><input type="text" name="re_publickey" size="80" value="'.$CACHEARRAY['re_publickey'].'"></td></tr>');
print('<tr><td>��������� ���� �����:</td><td><input type="text" name="re_privatekey" size="80" value="'.$CACHEARRAY['re_privatekey'].'"></td></tr>');

print('<tr><td align="center" colspan="2" class="colhead">��������� �����������</td></tr>');

print('<tr><td>������������ ���������� �������������:</td><td><input type="text" name="maxusers" size="6" value="'.$CACHEARRAY['maxusers'].'">�������������</td></tr>');
print('<tr><td>������������ ���������� ��������� � ������ �����:</td><td><input type="text" name="pm_max" size="4" value="'.$CACHEARRAY['pm_max'].'">���������</td></tr>');
print('<tr><td>������������ ������ ������:</td><td><input type="text" name="avatar_max_width" size="3" value="'.$CACHEARRAY['avatar_max_width'].'">��������</td></tr>');
print('<tr><td>������������ ������ ������:</td><td><input type="text" name="avatar_max_height" size="3" value="'.$CACHEARRAY['avatar_max_height'].'">��������</td></tr>');
print('<tr><td>��������� ����������� � ��������� �������:</td><td><select name="nc"><option value="yes" '.($CACHEARRAY['nc']=="yes"?"selected":"").'>��</option><option value="no" '.($CACHEARRAY['nc']=="no"?"selected":"").'>���</option></select></td></tr>');
print('<tr><td>����������� ���������� ������� ��� ����������� �������� ��������:</td><td><input type="text" name="minvotes" size="2" value="'.$CACHEARRAY['minvotes'].'">�������</td></tr>');
print('<tr><td>������������ ������ �������-����� � ������:</td><td><input type="text" name="max_torrent_size" size="10" value="'.$CACHEARRAY['max_torrent_size'].'">����</td></tr>');
print('<tr><td>������������ ���������� �������� ��� ������:<br/><small>*��� ��������� ����� ��������� ���������� �������� ��� thumbnail</small></td><td><input type="text" name="max_images" size="2" value="'.$CACHEARRAY['max_images'].'">��������, "2"</td></tr>');

print('<tr><td align="center" colspan="2" class="colhead">��������� �������</td></tr>');

print('<tr><td>���������� ����, �� ���������� ������� ��������� ���������������� ��������:</td><td><input type="text" name="signup_timeout" size="2" value="'.$CACHEARRAY['signup_timeout'].'">����</td></tr>');
print('<tr><td>����� � ���, ����� ������� ������� ��������� �������:</td><td><input type="text" name="max_dead_torrent_time" size="3" value="'.$CACHEARRAY['max_dead_torrent_time'].'">������</td></tr>');
print('<tr><td>�������� �������� (���������� ���������� � ��������) � �������:</td><td><input type="text" name="announce_interval" size="2" value="'.$CACHEARRAY['announce_interval'].'">�����</td></tr>');
print('<tr><td>����� ������� �� � ��������:</td><td><input type="text" name="autoclean_interval" size="4" value="'.$CACHEARRAY['autoclean_interval'].'">������</td></tr>');
print('<tr><td>���������� ���� ��� ������� ������ ��������� �� �������:</td><td><input type="text" name="pm_delete_sys_days" size="2" value="'.$CACHEARRAY['pm_delete_sys_days'].'">����</td></tr>');
print('<tr><td>���������� ���� ��� ������� ������ ��������� �� ������������:</td><td><input type="text" name="pm_delete_user_days" size="2" value="'.$CACHEARRAY['pm_delete_user_days'].'">����</td></tr>');
print('<tr><td>����� ����� �������� �������� � ����:</td><td><input type="text" name="ttl_days" size="3" value="'.$CACHEARRAY['ttl_days'].'">����</td></tr>');

print('<tr><td align="center" colspan="2" class="colhead">��������� ������������</td></tr>');

print('<tr><td>����-�������� � ��������:</td><td><input type="text" name="as_timeout" size="10" value="'.$CACHEARRAY['as_timeout'].'">������</td></tr>');
print('<tr><td>������������ �������� ��������� 5 ������������ (��������):</td><td><select name="as_check_messages"><option value="1" '.($CACHEARRAY['as_check_messages']==1?"selected":"").'>��</option><option value="0" '.($CACHEARRAY['as_check_messages']==0?"selected":"").'>���</option></select></td></tr>');
print('<tr><td>�����-�����:</td><td><select name="debug_mode"><option value="1" '.($CACHEARRAY['debug_mode']==1?"selected":"").'>��</option><option value="0" '.($CACHEARRAY['debug_mode']==0?"selected":"").'>���</option></select></td></tr>');

print('<tr><td align="center" colspan="2" class="colhead">������</td></tr>');

print('<tr><td>���������� ������� � ������ ������� �� ��������:<br/><small>*��� ��������� ����� ��������� ���������� �������� ��� browse</small></td><td><input type="text" name="torrentsperpage" size="3" value="'.$CACHEARRAY['torrentsperpage'].'">�������</td></tr>');
print('<tr><td>������� ������������� ������ ������� � ��� ��� ����������� 1 ��������:</td><td><input type="text" name="points_per_hour" size="2" value="'.$CACHEARRAY['points_per_hour'].'">�������</td></tr>');
print('<tr><td>������������ TTL (���� �������� ������� ���������):</td><td><select name="use_ttl"><option value="1" '.($CACHEARRAY['use_ttl']==1?"selected":"").'>��</option><option value="0" '.($CACHEARRAY['use_ttl']==0?"selected":"").'>���</option></select></td></tr>');
print('<tr><td>������������ ������� ����������� ������� �� �������:</td><td><select name="use_wait"><option value="1" '.($CACHEARRAY['use_wait']==1?"selected":"").'>��</option><option value="0" '.($CACHEARRAY['use_wait']==0?"selected":"").'>���</option></select></td></tr>');

print('<tr><td align="center" colspan="2"><input type="submit" value="��������� ���������"><input type="reset" value="��������"></td></tr></table>');

}

elseif ($_GET['action'] == 'save'){
       $reqparametres = array('torrentsperpage','maxusers','max_dead_torrent_time','minvotes','signup_timeout',
'announce_interval','max_torrent_size','max_images','defaultbaseurl','siteemail','adminemail','sitename','description','keywords',
'forumname','autoclean_interval','yourcopy','pm_delete_sys_days','pm_delete_user_days','pm_max','ttl_days','default_language',
'avatar_max_width','avatar_max_height','watermark','points_per_hour','default_theme','nc','deny_signup','allow_invite_signup',
'use_ttl','use_email_act','use_wait','use_lang','use_captcha','use_blocks','use_gzip','use_ipbans','use_sessions','smtptype',
'as_timeout','as_check_messages','use_integration','debug_mode','ipb_cookie_prefix');
       $int_param = array('exporttype','forumurl','forum_bin_id','defuserclass','not_found_export_id','emo_dir');
       $captcha_param = array('re_publickey','re_privatekey');

       $updateset = array();

       foreach ($reqparametres as $param) {
         if (!isset($_POST[$param]) && ($param != 'forumname') && ($param != 'ipb_cookie_prefix')) stderr($tracker_lang['error'],"��������� ���� �� ��������� ($param)");
       $updateset[] = "UPDATE cache_stats SET cache_value=".sqlesc($_POST[$param])." WHERE cache_name='$param'";
       }

       if ($_POST['use_integration'] == 1) {
         foreach ($int_param as $param) {
         if (!$_POST[$param] || !isset($_POST[$param])) stderr($tracker_lang['error'],"��������� ���� ��� ���������� � ������� �� ���������");
       $updateset[] = "UPDATE cache_stats SET cache_value=".sqlesc($_POST[$param])." WHERE cache_name='$param'";
       }
     }

            if ($_POST['use_captcha'] == 1) {
         foreach ($captcha_param as $param) {
         if (!$_POST[$param] || !isset($_POST[$param])) stderr($tracker_lang['error'],"��������� ��� ��������� ����� ����� �� ����������");
       $updateset[] = "UPDATE cache_stats SET cache_value=".sqlesc($_POST[$param])." WHERE cache_name='$param'";
       }
     }

     foreach ($updateset as $query) sql_query($query);
     header("Location: transfer.php?step=3");

}
}

elseif ($_GET['step'] ==3) {
  dbconn();
$descr_typeid = 242;
$torrent = sql_query("SELECT id,descr FROM torrents ORDER BY id ASC");
while ($t = mysql_fetch_array($torrent)) {
  mysql_query("INSERT INTO descr_torrents (torrent,typeid,value) VALUES (".$t['id'].",".$descr_typeid.",".sqlesc($t['descr']).")") or die(mysql_error());

}
print "�������� ������� ����������, ������ ���������� �������� ������� �������� ��� �������<hr/>";
print "Descriptions were sucessfully transfered, now script will update releases' description templates<hr/>";
print '<a href="transfer.php?step=4">����������/Continue</a>';
}

elseif ($_GET['step'] == 4) {
  dbconn();
       sql_query("UPDATE torrents SET descr_type = 25") or die('<font color="red">FAIL</font>, ������ MySQL / MySQL error ['.mysql_errno().']: ' . mysql_error());

print "������� �������� ������� ������� ���������, ��������� ��� �������� � ������ ��� �� ������ ��������<hr/>";
print "Releases' description templates were successfully updated, next step will make cleanup of descriptions<hr/>";
print '<a href="transfer.php?step=5">����������/Continue</a>';
}
elseif ($_GET['step'] == 5) {
  dbconn();
  sql_query("ALTER TABLE  `torrents`  DROP COLUMN  `descr`") or die('<font color="red">FAIL</font>, ������ MySQL / MySQL error ['.mysql_errno().']: ' . mysql_error());

  sql_query("ALTER TABLE  `torrents`  DROP COLUMN  `ori_descr`") or die('<font color="red">FAIL</font>, ������ MySQL / MySQL error ['.mysql_errno().']: ' . mysql_error());

print "������� �������� ��������, ��������� ��� ��������� �������� ���������<hr/>";
print "Old descriptions were sucessfully cleaned, next step will transfer torrents' images<hr/>";
print '<a href="transfer.php?step=6">����������/Continue</a>';
}

elseif ($_GET['step'] ==6) {
dbconn();
$query = mysql_query('SELECT id,image1,image2 FROM torrents ORDER BY id ASC');

while ($row = mysql_fetch_array($query)) {
  $id = $row['id'];
  if ($row['image1']) $images[] = $row['image1'];
  if ($row['image2']) $images[] = $row['image2'];
  $imgs = implode(',',$images);
  mysql_query ("UPDATE torrents SET images = '$imgs' WHERE id = $id");
  unset($images);
}
sql_query('ALTER TABLE  `torrents`  DROP COLUMN  `image1`');
sql_query('ALTER TABLE  `torrents`  DROP COLUMN  `image2`');

print '�������� ������� ����������, ������ ������ ������� announce-url ��������� ��� ����������� ���������������� �����������������.<hr/>';
print 'Images were sucessfully transfered, now script will clean announce-url of torrents for normal multi-tracker feature functionality.<hr/>';
print '<a href="transfer.php?step=7">����������/Continue</a>';
}

elseif ($_GET['step'] == 7) {
require_once(ROOT_PATH.'include/benc.php');
dbconn();

$res = sql_query('SELECT id FROM torrents ORDER BY id DESC');
while (list($id) = mysql_fetch_array($res)){

$fn = ROOT_PATH."/torrents/$id.torrent";
if (is_readable($fn)) {
$dict = bdec_file($fn, (1024*1024));
unlink($fn);
unset($dict['value']['announce']);
unset($dict['value']['nodes']); // remove cached peers (Bitcomet & Azareus)
unset($dict['value']['azureus_properties']); // remove azureus properties
unset($dict['value']['comment']);
unset($dict['value']['created by']);
unset($dict['value']['publisher']);
unset($dict['value']['publisher.utf-8']);
unset($dict['value']['publisher-url']);
unset($dict['value']['publisher-url.utf-8']);

	$fp = fopen(ROOT_PATH."torrents/$id.torrent", "w");
	if ($fp) {
	    @fwrite($fp, benc($dict), strlen(benc($dict)));
	    fclose($fp);
	    @chmod($fp, 0644);
	}
  print ("$id - <font color=\"green\">OK, announce deleted</font><br/>");
}

else {

print ("$id - NO TORRENT <br/>");
}
}

print 'Announce-url ������ �������, ������ ������ ������� ���.<hr/>';
print 'Announce-url wer successfuly cleanet, now script will clear cache.<hr/>';
print '<a href="transfer.php?step=8">����������/Continue</a>';
}

elseif ($_GET['step'] == 8) {
  dbconn();
if (!defined("CACHE_REQUIRED")) {
  	require_once ROOT_PATH.'classes/cache/cache.class.php';
	require_once ROOT_PATH.'classes/cache/fileCacheDriver.class.php';
}

  		$cache=new Cache();
		$cache->addDriver('file', new FileCacheDriver());

  $cache->clearAllCache();
print "������� �� Kinokpk.com releaser 2.40 ������� ��������! �� ��������� ������� ���� ���� � update.sql � ������ �������.<hr/>";
print "You have successfully transfered to Kinokpk.com releaser 2.40! DO NOT FORGET TO DELETE THIS FILE AND update.sql FROM YOUR SERVER.<hr/>";
print '<a href="javascript:self.close();" >������� ����/Close this window</a><hr/>';
print '<script language="javascript">alert(\'������� �� ����� Kinokpk.com releaser 2.40/Thank you for choosing Kinokpk.com releaser 2.40\');</script>';
}
?>