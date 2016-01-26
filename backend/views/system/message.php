<div class="main-layout">
    <table align="center" width="400">
      <tr>
        <td width="50" valign="top">
          <?php if ($msg_type == 0):?>
          <img src="/images/information.gif" width="32" height="32" border="0" alt="information" />
          <?php elseif ($msg_type == 1):?>
          <img src="/images/warning.gif" width="32" height="32" border="0" alt="warning" />
          <?php else:?>
          <img src="/images/confirm.gif" width="32" height="32" border="0" alt="confirm" />
          <?php endif;?>
        </td>
        <td style="font-size: 14px; font-weight: bold"><?=$msg_detail?></td>
      </tr>
      <tr>
        <td></td>
        <td id="redirectionMsg">
          <?php if ($auto_redirect):?><span id="spanSeconds" style="font-size: 14px;color:red">5</span><?=Yii::t('app', 'auto_redirection')?><?php endif;?>
        </td>
      </tr>
      <tr>
        <td></td>
        <td>
          <ul style="margin:0; padding:0 10px" class="msg-link">
            <?php foreach ($links as $link):?>
            <li><a href="<?=$link['href']?>" <?php if (!empty($link['target'])):?>target="<?=$link['target']?>"<?php endif;?>><?=$link['text']?></a></li>
           <?php endforeach;?>
          </ul>

        </td>
      </tr>
    </table>
</div>
<?php if ($auto_redirect):?>
<script type="text/javascript">
<!--
var seconds = 5;
var defaultUrl = "<?=$default_url?>";

onload = function()
{
	if (defaultUrl == 'javascript:history.go(-1)' && window.history.length == 0)
	{
	    document.getElementById('redirectionMsg').innerHTML = '';
	    return;
	}
	window.setInterval(redirection, 1000);
}
function redirection()
{
  if (seconds <= 0)
  {
    window.clearInterval();
    return;
  }

  seconds --;
  document.getElementById('spanSeconds').innerHTML = seconds;

  if (seconds == 0)
  {
    window.clearInterval();
    self.location.href = defaultUrl;
  }
}
//-->
</script>
<?php endif;?>