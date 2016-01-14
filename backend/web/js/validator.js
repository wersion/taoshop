/* *
 * ECSHOP 琛ㄥ崟楠岃瘉绫�
 * ============================================================================
 * 鐗堟潈鎵€鏈� (C) 2005-2011 搴风洓鍒涙兂锛堝寳浜級绉戞妧鏈夐檺鍏徃锛屽苟淇濈暀鎵€鏈夋潈鍒┿€�
 * 缃戠珯鍦板潃 : http : // www.ecshop.com
 * ----------------------------------------------------------------------------
 * 杩欐槸涓€涓厤璐瑰紑婧愮殑杞欢锛涜繖鎰忓懗鐫€鎮ㄥ彲浠ュ湪涓嶇敤浜庡晢涓氱洰鐨勭殑鍓嶆彁涓嬪绋嬪簭浠ｇ爜
 * 杩涜淇敼鍜屽啀鍙戝竷銆�
 * ============================================================================
 * $Author : paulgao $
 * $Date : 2007-01-31 16:23:56 +0800 (鏄熸湡涓�, 31 涓€鏈� 2007) $
 * $Id : validator.js 4824 2007-01-31 08:23:56Z paulgao $

 *//* *
 * 琛ㄥ崟楠岃瘉绫�
 *
 * @author : weber liu
 * @version : v1.1
 */

var Validator = function(name)
{
  this.formName = name;
  this.errMsg = new Array();

  /* *
  * 妫€鏌ョ敤鎴锋槸鍚﹁緭鍏ヤ簡鍐呭
  *
  * @param :  controlId   琛ㄥ崟鍏冪礌鐨処D
  * @param :  msg         閿欒鎻愮ず淇℃伅
  */
  this.required = function(controlId, msg)
  {
    var obj = document.forms[this.formName].elements[controlId];
    if (typeof(obj) == "undefined" || Utils.trim(obj.value) == "")
    {
      this.addErrorMsg(msg);
    }
  }
  ;

  /* *
  * 妫€鏌ョ敤鎴疯緭鍏ョ殑鏄惁涓哄悎娉曠殑閭欢鍦板潃
  *
  * @param :  controlId   琛ㄥ崟鍏冪礌鐨処D
  * @param :  msg         閿欒鎻愮ず淇℃伅
  * @param :  required    鏄惁蹇呴』
  */
  this.isEmail = function(controlId, msg, required)
  {
    var obj = document.forms[this.formName].elements[controlId];
    obj.value = Utils.trim(obj.value);

    if ( ! required && obj.value == '')
    {
      return;
    }

    if ( ! Utils.isEmail(obj.value))
    {
      this.addErrorMsg(msg);
    }
  }

  /* *
  * 妫€鏌ヤ袱涓〃鍗曞厓绱犵殑鍊兼槸鍚︾浉绛�
  *
  * @param : fstControl   琛ㄥ崟鍏冪礌鐨処D
  * @param : sndControl   琛ㄥ崟鍏冪礌鐨処D
  * @param : msg         閿欒鎻愮ず淇℃伅
  */
  this.eqaul = function(fstControl, sndControl, msg)
  {
    var fstObj = document.forms[this.formName].elements[fstControl];
    var sndObj = document.forms[this.formName].elements[sndControl];

    if (fstObj != null && sndObj != null)
    {
      if (fstObj.value == '' || fstObj.value != sndObj.value)
      {
        this.addErrorMsg(msg);
      }
    }
  }

  /* *
  * 妫€鏌ュ墠涓€涓〃鍗曞厓绱犳槸鍚﹀ぇ浜庡悗涓€涓〃鍗曞厓绱�
  *
  * @param : fstControl   琛ㄥ崟鍏冪礌鐨処D
  * @param : sndControl   琛ㄥ崟鍏冪礌鐨処D
  * @param : msg                閿欒鎻愮ず淇℃伅
  */
  this.gt = function(fstControl, sndControl, msg)
  {
    var fstObj = document.forms[this.formName].elements[fstControl];
    var sndObj = document.forms[this.formName].elements[sndControl];

    if (fstObj != null && sndObj != null) {
      if (Utils.isNumber(fstObj.value) && Utils.isNumber(sndObj.value)) {
        var v1 = parseFloat(fstObj.value) + 0;
        var v2 = parseFloat(sndObj.value) + 0;
      } else {
        var v1 = fstObj.value;
        var v2 = sndObj.value;
      }

      if (v1 <= v2) this.addErrorMsg(msg);
    }
  }

  /* *
  * 妫€鏌ヨ緭鍏ョ殑鍐呭鏄惁鏄竴涓暟瀛�
  *
  * @param :  controlId   琛ㄥ崟鍏冪礌鐨処D
  * @param :  msg         閿欒鎻愮ず淇℃伅
  * @param :  required    鏄惁蹇呴』
  */
  this.isNumber = function(controlId, msg, required)
  {
    var obj = document.forms[this.formName].elements[controlId];
    obj.value = Utils.trim(obj.value);

    if (obj.value == '' && ! required)
    {
      return;
    }
    else
    {
      if ( ! Utils.isNumber(obj.value))
      {
        this.addErrorMsg(msg);
      }
    }
  }

  /* *
  * 妫€鏌ヨ緭鍏ョ殑鍐呭鏄惁鏄竴涓暣鏁�
  *
  * @param :  controlId   琛ㄥ崟鍏冪礌鐨処D
  * @param :  msg         閿欒鎻愮ず淇℃伅
  * @param :  required    鏄惁蹇呴』
  */
  this.isInt = function(controlId, msg, required)
  {

    if (document.forms[this.formName].elements[controlId])
    {
      var obj = document.forms[this.formName].elements[controlId];
    }
    else
    {
      return;    
    }

    obj.value = Utils.trim(obj.value);

    if (obj.value == '' && ! required)
    {
      return;
    }
    else
    {
      if ( ! Utils.isInt(obj.value)) this.addErrorMsg(msg);
    }
  }

  /* *
  * 妫€鏌ヨ緭鍏ョ殑鍐呭鏄惁鏄负绌�
  *
  * @param :  controlId   琛ㄥ崟鍏冪礌鐨処D
  * @param :  msg         閿欒鎻愮ず淇℃伅
  * @param :  required    鏄惁蹇呴』
  */
  this.isNullOption = function(controlId, msg)
  {
    var obj = document.forms[this.formName].elements[controlId];

    obj.value = Utils.trim(obj.value);

    if (obj.value > '0' )
    {
      return;
    }
    else
    {
      this.addErrorMsg(msg);
    }
  }

  /* *
  * 妫€鏌ヨ緭鍏ョ殑鍐呭鏄惁鏄�"2006-11-12 12:00:00"鏍煎紡
  *
  * @param :  controlId   琛ㄥ崟鍏冪礌鐨処D
  * @param :  msg         閿欒鎻愮ず淇℃伅
  * @param :  required    鏄惁蹇呴』
  */
  this.isTime = function(controlId, msg, required)
  {
    var obj = document.forms[this.formName].elements[controlId];
    obj.value = Utils.trim(obj.value);

    if (obj.value == '' && ! required)
    {
      return;
    }
    else
    {
      if ( ! Utils.isTime(obj.value)) this.addErrorMsg(msg);
    }
  }
  
  /* *
  * 妫€鏌ュ墠涓€涓〃鍗曞厓绱犳槸鍚﹀皬浜庡悗涓€涓〃鍗曞厓绱�(鏃ユ湡鍒ゆ柇)
  *
  * @param : controlIdStart   琛ㄥ崟鍏冪礌鐨処D
  * @param : controlIdEnd     琛ㄥ崟鍏冪礌鐨処D
  * @param : msg              閿欒鎻愮ず淇℃伅
  */
  this.islt = function(controlIdStart, controlIdEnd, msg)
  {
    var start = document.forms[this.formName].elements[controlIdStart];
    var end = document.forms[this.formName].elements[controlIdEnd];
    start.value = Utils.trim(start.value);
    end.value = Utils.trim(end.value);

    if(start.value <= end.value)
    {
      return;
    }
    else
    {
      this.addErrorMsg(msg);
    }
  }

  /* *
  * 妫€鏌ユ寚瀹氱殑checkbox鏄惁閫夊畾
  *
  * @param :  controlId   琛ㄥ崟鍏冪礌鐨刵ame
  * @param :  msg         閿欒鎻愮ず淇℃伅
  */
  this.requiredCheckbox = function(chk, msg)
  {
    var obj = document.forms[this.formName].elements[controlId];
    var checked = false;

    for (var i = 0; i < objects.length; i ++ )
    {
      if (objects[i].type.toLowerCase() != "checkbox") continue;
      if (objects[i].checked)
      {
        checked = true;
        break;
      }
    }

    if ( ! checked) this.addErrorMsg(msg);
  }

  this.passed = function()
  {
    if (this.errMsg.length > 0)
    {
      var msg = "";
      for (i = 0; i < this.errMsg.length; i ++ )
      {
        msg += "- " + this.errMsg[i] + "\n";
      }

      alert(msg);
      return false;
    }
    else
    {
      return true;
    }
  }

  /* *
  * 澧炲姞涓€涓敊璇俊鎭�
  *
  * @param :  str
  */
  this.addErrorMsg = function(str)
  {
    this.errMsg.push(str);
  }
}

/* *
 * 甯姪淇℃伅鐨勬樉闅愬嚱鏁�
 */
function showNotice(objId)
{
  var obj = document.getElementById(objId);

  if (obj)
  {
    if (obj.style.display != "block")
    {
      obj.style.display = "block";
    }
    else
    {
      obj.style.display = "none";
    }
  }
}

/* *
 * add one option of a select to another select.
 *
 * @author  Chunsheng Wang < wwccss@263.net >
 */
function addItem(src, dst)
{
  for (var x = 0; x < src.length; x ++ )
  {
    var opt = src.options[x];
    if (opt.selected && opt.value != '')
    {
      var newOpt = opt.cloneNode(true);
      newOpt.className = '';
      newOpt.text = newOpt.innerHTML.replace(/^\s+|\s+$|&nbsp;/g, '');
      dst.appendChild(newOpt);
    }
  }

  src.selectedIndex = -1;
}

/* *
 * move one selected option from a select.
 *
 * @author  Chunsheng Wang < wwccss@263.net >
 */
function delItem(ItemList)
{
  for (var x = ItemList.length - 1; x >= 0; x -- )
  {
    var opt = ItemList.options[x];
    if (opt.selected)
    {
      ItemList.options[x] = null;
    }
  }
}

/* *
 * join items of an select with ",".
 *
 * @author  Chunsheng Wang < wwccss@263.net >
 */
function joinItem(ItemList)
{
  var OptionList = new Array();
  for (var i = 0; i < ItemList.length; i ++ )
  {
    OptionList[OptionList.length] = ItemList.options[i].text + "|" + ItemList.options[i].value;
  }
  return OptionList.join(",");
}