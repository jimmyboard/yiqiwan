function Dsy() {
    this.Items = {};
}
Dsy.prototype.add = function (id, iArray) {
    this.Items[id] = iArray;
}
Dsy.prototype.Exists = function (id) {
    if (typeof(this.Items[id]) == "undefined") return false;
    return true;
}

function change(v) {
    // alert(v);
    var str = "0";
    for (i = 0; i < v; i++) { 
        str += ("_" + (document.getElementById(s[i]).selectedIndex - 1));
    };
    // alert(str);
    var ss = document.getElementById(s[v]);
    with (ss) {
        length = 0;
        options[0] = new Option(opt0[v], opt0[v]);
        if (v && document.getElementById(s[v - 1]).selectedIndex > 0 || !v) {
            if (dsy.Exists(str)) {
                ar = dsy.Items[str];
                for (i = 0; i < ar.length; i++)options[length] = new Option(ar[i], ar[i]);
                if (v)options[0].selected = true;
            }
        }
        if (++v < s.length) {change(v);}
    }
}

var dsy = new Dsy();
dsy.add("0_5", ["梅沙街道", "沙头角街道", "海山街道", "盐田街道"]);

dsy.add("0_4", ["南湾街道", "南澳街道", "坂田街道", "坑梓街道", "坪地街道", "坪山街道", "大鹏街道", "布吉街道", "平湖街道", "横岗街道", "葵涌街道", "龙城街道", "龙岗街道"]);

dsy.add("0_3", ["光明街道", "公明街道", "大浪街道", "新安街道", "松岗街道", "民治街道", "沙井街道", "石岩街道", "福永街道", "西乡街道", "观澜街道", "龙华街道"]);

dsy.add("0_2", ["南头街道", "南山街道", "招商街道", "桃源街道", "沙河街道", "粤海街道", "蛇口街道", "西丽街道"]);

dsy.add("0_1", ["东晓街道", "东湖街道", "东门街道", "南湖街道", "桂园街道", "清水河街道", "笋岗街道", "翠竹街道", "莲塘街道", "黄贝街道"]);

dsy.add("0_0", ["华富街道", "南园街道", "园岭街道", "梅林街道", "沙头街道", "福田街道", "莲花街道", "香密湖街道"]);

dsy.add("0", ["福田区", "罗湖区", "南山区", "宝安区", "龙岗区", "盐田区"]);

var s = ["s1", "s2"];

function setup() {
    for (i = 0; i < s.length - 1; i++)
        document.getElementById(s[i]).onchange = new Function("change(" + (i + 1) + ");");
    change(0);
}

function preselect(p_key) {
    // alert(p_key);
    var index;

    var provinces = new Array("福田区", "罗湖区", "南山区", "宝安区", "龙岗区", "盐田区");
    var cnt = provinces.length;
    // alert(cnt);
    for (i = 0; i < cnt; i++) {
        if (p_key == provinces[i]) {
            index = i;
            break;
        }
    }
    if (index < provinces.length) {
        document.getElementById(s[0]).selectedIndex = index + 1;
        change(1);
    }
}
