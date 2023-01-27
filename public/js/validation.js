jQuery.extend(jQuery.validator.messages, {
	required: "必填欄位",
	remote: "請修正該欄位",
	email: "請輸入正確格式的電子郵件",
	url: "請輸入合法的網址",
	date: "請輸入合法的日期",
	dateISO: "請輸入合法的日期 (ISO).",
	number: "請輸入合法的數字",
	digits: "只能輸入整數",
	creditcard: "請輸入合法的信用卡號",
	equalTo: "請再次輸入相同的值",
	accept: "請輸入擁有合法字尾名的字串",
	maxlength: jQuery.validator.format("請輸入一個 長度最多是 {0} 的字串"),
	minlength: jQuery.validator.format("請輸入一個 長度最少是 {0} 的字串"),
	rangelength: jQuery.validator.format("請輸入 一個長度介於 {0} 和 {1} 之間的字串"),
	range: jQuery.validator.format("請輸入一個介於 {0} 和 {1} 之間的值"),
	max: jQuery.validator.format("請輸入一個最大為{0} 的值"),
	min: jQuery.validator.format("請輸入一個最小為{0} 的值")
});