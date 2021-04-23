const add_submit = ( input, submit ) => {
	input.addEventListener('keyup', e => {
		if( e.keyCode === 13 ){
			submit.click()
		}
	})
}

export {
	add_submit,
}