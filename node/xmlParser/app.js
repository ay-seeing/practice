// 解析xml数据字符串
/*var parseString = require('xml2js').parseString;
var xml = '<?xml version="1.0" ?> <customer> <field id="firstName"> <value>David</value> </field> <field id="lastName"> <value>Smith</value> </field> <field id="country"> <value>China</value> </field> </customer>';
parseString(xml ,function(err,result){
	console.log(result);
	// 将result以字符串输出，而不现实project
	// console.log(util.inspect(result,false,null));
});
*/


// 解析xml数据文件
var fs = require('fs'),
	util = require('util'),
	xml2js = require('xml2js');
var parser = new xml2js.Parser();
fs.readFile(__dirname + '/customer.xml', function(err, data){
	parser.parseString(data, function(err,result){
		console.log(result);
		console.log(util.inspect(result,false,null));

		// 解析json数据
		// var str = JSON.stringify(result);
		// console.log(str);
		console.log('Done');
	})
})