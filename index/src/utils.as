import com.meychi.ascrypt.Base64;
import JSON;
/**
* JSON2Obj by Li Volsi Francesco
*/
function JSON2Obj(str_json:String):Object
{
	//JSON
	var json:JSON = new JSON();	
	//trace("-----------------------------------------------------------------------");
	//trace("DATA ENCODED: "+str_json);
	str_json = Base64.decode(str_json);
	//trace("DATA DECODED: "+str_json);    
    try {
        var toObj:Object = json.parse(str_json);
    } catch(ex) {
        trace(ex.name + ":" + ex.message + ":" + ex.at + ":" + ex.text);
	}
	for (var a in toObj) {
		//trace(a + "=>" + toObj[a]);
		for (var b in toObj[a]) {
			//trace(" "+b +"=>"+toObj[a][b]);
			for (var c in toObj[a][b]) {
				//trace("  "+c +"=>"+toObj[a][b][c]);
			}		
		}
	}
	//trace("-----------------------------------------------------------------------");
	return toObj;
}
/**
* XML2Obj for 3 Level array by Li Volsi Francesco
*/
function XML2Obj3Level(str_xml:String, obj:Object):Void 
{
	//trace("-----------------------------------------------------------------------");
	////trace("encrypt: "+str_xml);
	str_xml = Base64.decode(str_xml);
	////trace("decrypt: "+str_xml);
	var my_xml:XML = new XML(str_xml);
	my_xml.ignoreWhite = true;
	var elements = my_xml.firstChild.childNodes;
	for (var a = 0; a<elements.length; a++) {
		var curr_pos = elements[a];
		obj[curr_pos.attributes.key] = new Object();
		if (curr_pos.firstChild.hasChildNodes()) {
			//Stop nodes
			var elements_1 = curr_pos.childNodes;
			for (var b = 0; b<elements_1.length; b++) {
				var curr_pos_1 = elements_1[b];
				obj[curr_pos.attributes.key][curr_pos_1.attributes.key] = new Object();
				if (curr_pos_1.firstChild.hasChildNodes()) {
					var elements_2 = curr_pos_1.childNodes;
					for (var c = 0; c<elements_2.length; c++) {
						var curr_pos_2 = elements_2[c];
						obj[curr_pos.attributes.key][curr_pos_1.attributes.key][curr_pos_2.attributes.key] = new Object();
						if (curr_pos_2.firstChild.hasChildNodes()) {
							//Stop nodes
							var elements_3 = curr_pos_2.childNodes;
							for (var d = 0; d<elements_3.length; d++) {
								var curr_pos_3 = elements_3[d];
								obj[curr_pos.attributes.key][curr_pos_1.attributes.key][curr_pos_2.attributes.key][curr_pos_3.attributes.key] = new Object();
								if (curr_pos_3.firstChild.hasChildNodes()) {
									//Stop nodes
									var elements_4 = curr_pos_3.childNodes;
									for (var e = 0; e<elements_4.length; e++) {
										var curr_pos_4 = elements_4[e];	
										obj[curr_pos.attributes.key][curr_pos_1.attributes.key][curr_pos_2.attributes.key][curr_pos_3.attributes.key][curr_pos_4.attributes.key] = new Object();
										if (curr_pos_4.firstChild.hasChildNodes()) {
											//Stop nodes
										} else {
											obj[curr_pos.attributes.key][curr_pos_1.attributes.key][curr_pos_2.attributes.key][curr_pos_3.attributes.key][curr_pos_4.attributes.key] = curr_pos_4.firstChild.toString();
											//trace("["+curr_pos.attributes.key+"]["+curr_pos_1.attributes.key+"]["+curr_pos_2.attributes.key+"]["+curr_pos_3.attributes.key+"]["+curr_pos_4.attributes.key+"] => "+obj[curr_pos.attributes.key][curr_pos_1.attributes.key][curr_pos_2.attributes.key][curr_pos_3.attributes.key][curr_pos_4.attributes.key]);
										}
									}									
								} else {
									obj[curr_pos.attributes.key][curr_pos_1.attributes.key][curr_pos_2.attributes.key][curr_pos_3.attributes.key] = curr_pos_3.firstChild.toString();
									//trace("["+curr_pos.attributes.key+"]["+curr_pos_1.attributes.key+"]["+curr_pos_2.attributes.key+"]["+curr_pos_3.attributes.key+"] => "+obj[curr_pos.attributes.key][curr_pos_1.attributes.key][curr_pos_2.attributes.key][curr_pos_3.attributes.key]);
								}
							}							
							
						} else {
							obj[curr_pos.attributes.key][curr_pos_1.attributes.key][curr_pos_2.attributes.key] = curr_pos_2.firstChild.toString();
							//trace("["+curr_pos.attributes.key+"]["+curr_pos_1.attributes.key+"]["+curr_pos_2.attributes.key+"] => "+obj[curr_pos.attributes.key][curr_pos_1.attributes.key][curr_pos_2.attributes.key]);
						}
					}
				} else {
					obj[curr_pos.attributes.key][curr_pos_1.attributes.key] = curr_pos_1.firstChild.toString();
					//trace("["+curr_pos.attributes.key+"]["+curr_pos_1.attributes.key+"] => "+obj[curr_pos.attributes.key][curr_pos_1.attributes.key]);
				}
			}
		} else {
			obj[curr_pos.attributes.key] = curr_pos.firstChild.toString();
			//trace("["+curr_pos.attributes.key+"] => "+obj[curr_pos.attributes.key]);
			if (curr_pos.attributes.key == 'curr_idsubhand')
			{
				if ((Number(obj[curr_pos.attributes.key])) <= _root.idsubhand_inserted) {
					obj['response'] = "OK";
					//trace("-----------------------------------------------------------------------");
					return;
				}
			}
		}
	}
	//trace("-----------------------------------------------------------------------");
}
/**
* formatNumber by Li Volsi Francesco
*/
function formatNumber(num:Number, dec:Number):String
{
    var str:String = String(num);
    if (str.indexOf(".") < 0) str += ".";
    dec = dec < 0 ? dec-3 : dec-(str.length-str.indexOf(".")-2);
    var numbers:Array = str.split("");
    while ((dec--)>0) { numbers.push(0); }
    while ((dec++)<0) { numbers.splice(numbers.length-1, 1); }
    if(numbers[numbers.length-1]==".") numbers.splice(numbers.length-1, 1);
    return numbers.join("");
}
//
function inArray(array:Array, val:String):Boolean {
	var res:Boolean = false;
	for (ele in array) {
		if (String(ele) == val) {
			res = true;
			break;
		}
	}
	return res;
}
/**
* replace
*/
String.prototype.replace = function(f, r) { return this.split(f).join(r); };
/**
* htmldecode
*/
function htmldecode(str:String):String {
	var tmp:String = str;
	tmp = tmp.replace("&apos;","'");
	tmp = tmp.replace("&amp;","&");
	tmp = tmp.replace("\\&quot;","\"");	
	tmp = tmp.replace("&quot;","\"");	
	return tmp;
}