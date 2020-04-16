
export default function(value) {

	let str = value.toLowerCase();
	return str.replace(/(^([a-zA-Z\p{M}]))|([ -][a-zA-Z\p{M}])/g,
    function($1){
        return $1.toUpperCase();
    });
}