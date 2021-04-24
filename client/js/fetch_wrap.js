import ui from './ui.js?v=5'

export default ( url, method, body, no_spinner ) => {

	return new Promise( ( resolve, reject ) => {

		if( !no_spinner ) ui.spinner.show()

		if( method.match(/post/i) ){

			fetch( url, {
				method: 'post',
				headers: {
					'Content-Type': 'application/json',
				},
				body: JSON.stringify( body )
			})
			.then( res => {
				res.json()
				.then( r => {
					if( !no_spinner )  ui.spinner.hide()
					resolve( r )
				}).catch( err => {
					if( !no_spinner )  ui.spinner.hide()
					reject( err )
				})
			}).catch( err => {
				if( !no_spinner )  ui.spinner.hide()
				reject( err )
			})
			.catch( err => {
				if( !no_spinner )  ui.spinner.hide()
				reject( err )
			})

		}else if( method.match(/get/i) ){

			fetch( url )
			.then( res => {
				res.json()
				.then( r => {
					if( !no_spinner )  ui.spinner.hide()
					resolve( r )
				}).catch( err => {
					if( !no_spinner )  ui.spinner.hide()
					reject( err )
				})
			}).catch( err => {
				if( !no_spinner )  ui.spinner.hide()
				reject( err )
			})
			.catch( err => {
				if( !no_spinner )  ui.spinner.hide()
				reject( err )
			})

		}else{

			if( !no_spinner )  ui.spinner.hide()
			reject('invalid fetch ' + url )
			
		}

	})


}

