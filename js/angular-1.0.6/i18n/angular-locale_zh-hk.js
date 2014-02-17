angular.module("ngLocale", [], ["$provide", function($provide) {
var PLURAL_CATEGORY = {ZERO: "zero", ONE: "one", TWO: "two", FEW: "few", MANY: "many", OTHER: "other"};
$provide.value("$locale", {
  "DATETIME_FORMATS": {
    "AMPMS": {
      "0": "上午",
      "1": "下午"
    },
    "DAY": {
      "0": "星期日",
      "1": "星期一",
      "2": "星期二",
      "3": "星期三",
      "4": "星期四",
      "5": "星期五",
      "6": "星期六"
    },
    "MONTH": {
      "0": "1月",
      "1": "2月",
      "2": "3月",
      "3": "4月",
      "4": "5月",
      "5": "6月",
      "6": "7月",
      "7": "8月",
      "8": "9月",
      "9": "10月",
      "10": "11月",
      "11": "12月"
    },
    "SHORTDAY": {
      "0": "週日",
      "1": "週一",
      "2": "週二",
      "3": "週三",
      "4": "週四",
      "5": "週五",
      "6": "週六"
    },
    "SHORTMONTH": {
      "0": "1月",
      "1": "2月",
      "2": "3月",
      "3": "4月",
      "4": "5月",
      "5": "6月",
      "6": "7月",
      "7": "8月",
      "8": "9月",
      "9": "10月",
      "10": "11月",
      "11": "12月"
    },
    "fullDate": "y年M月d日EEEE",
    "longDate": "y年M月d日",
    "medium": "y年M月d日 ahh:mm:ss",
    "mediumDate": "y年M月d日",
    "mediumTime": "ahh:mm:ss",
    "short": "yy年M月d日 ah:mm",
    "shortDate": "yy年M月d日",
    "shortTime": "ah:mm"
  },
  "NUMBER_FORMATS": {
    "CURRENCY_SYM": "$",
    "DECIMAL_SEP": ".",
    "GROUP_SEP": ",",
    "PATTERNS": {
      "0": {
        "gSize": 3,
        "lgSize": 3,
        "macFrac": 0,
        "maxFrac": 3,
        "minFrac": 0,
        "minInt": 1,
        "negPre": "-",
        "negSuf": "",
        "posPre": "",
        "posSuf": ""
      },
      "1": {
        "gSize": 3,
        "lgSize": 3,
        "macFrac": 0,
        "maxFrac": 2,
        "minFrac": 2,
        "minInt": 1,
        "negPre": "(\u00A4",
        "negSuf": ")",
        "posPre": "\u00A4",
        "posSuf": ""
      }
    }
  },
  "id": "zh-hk",
  "pluralCat": function (n) {  return PLURAL_CATEGORY.OTHER;}
});
}]);