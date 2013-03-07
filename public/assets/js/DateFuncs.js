var DateFuncs = {

	diffMinut: function(d1, d2) {
        var t2 = d2.getTime();
        var t1 = d1.getTime();

        return parseInt((t2-t1)/(60*1000));
    },

	diffHours: function(d1, d2) {
        var t2 = d2.getTime();
        var t1 = d1.getTime();

        return parseInt((t2-t1)/(3600*1000));
    },

    diffDays: function(d1, d2) {
        var t2 = d2.getTime();
        var t1 = d1.getTime();

        return parseInt((t2-t1)/(24*3600*1000));
    },
	
	diffWeeks: function(d1, d2) {
        var t2 = d2.getTime();
        var t1 = d1.getTime();

        return parseInt((t2-t1)/(24*3600*1000*7));
    },

    diffMonths: function(d1, d2) {
        var d1Y = d1.getFullYear();
        var d2Y = d2.getFullYear();
        var d1M = d1.getMonth();
        var d2M = d2.getMonth();

        return (d2M+12*d2Y)-(d1M+12*d1Y);
    },

    diffYears: function(d1, d2) {
        return d2.getFullYear()-d1.getFullYear();
    }

    ,dateAdd:	function(datePart,Num,srcDate){
    	var msAdd;
    	switch(datePart)
		{
		case "m":
		  msAdd = Num * 60*1000;
		  break;
		case "h":
		  msAdd = Num * 3600*1000;
		  break;
		default:
		  msAdd = 0;
		}

		srcDate = srcDate.getTime();

    	return new Date(srcDate + msAdd);
    }

    ,getDateFromString: 	function (p_DateString){
		if(p_DateString.length==0)return null;

		var strDate = p_DateString.substring(0,10);	//"2012-12-31";

		var strTime = p_DateString.substring(11,19); //"17:36:42";

		var dateParts = strDate.split("-");
		var timeParts = strTime.split(":");

		var date = new Date(dateParts[0], (dateParts[1] - 1), dateParts[2], timeParts[0], timeParts[1], timeParts[2]);
		return date;	
	}

	,getHourMinut: function(d) {
        var sdate = "0"+d.getMinutes();

		sdate = sdate.substring(sdate.length-2,sdate.length);
		sdate = d.getHours()+":"+sdate;

		return sdate;
    }

    ,getSQLdate: function(d) {
        var sdate = d.getFullYear()+"-"+(d.getMonth()+1)+"-"+d.getDate()+" "+d.getHours()+":"+d.getMinutes()+":"+d.getSeconds()
        if(bDebug)console.log("getSQLdate. sdate: "+sdate);
		return sdate;
    }
}