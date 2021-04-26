const add_submit = ( input, submit ) => {
	input.addEventListener('keyup', e => {
		if( e.keyCode === 13 ){
			submit.click()
		}
	})
}

const orderby = ( set, type, direction, key ) => {

	if( !Array.isArray( set ) ){
		console.log('invalid sort')
		return []
	}

	let val1, val2

	switch( type ){

		case 'alphabetical':
			set.sort(( a, b ) => {
				val1 = key ? a[key].toUpperCase() : a.toUpperCase()
				val2 = key ? b[key].toUpperCase() : b.toUpperCase()
				if( val1 > val2 ) return 1 * direction
				if( val1 < val2 ) return -1 * direction
				return 0
			})
			break;

		default:
			console.log('unhandled sort')
			break;

	}

	return set

}

export {
	add_submit,
	orderby,
}