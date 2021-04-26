import { Modal } from './Modal.js?v=8'
import * as lib from './lib.js?v=8'
import hal from './hal.js?v=8'
import env from './env.js?v=8'
import fetch_wrap from './fetch_wrap.js?v=8'


const init = () => {

	const nav_menu = document.querySelector('#nav-menu')
	const nav_toggle = document.querySelector('#nav-toggle')

	const acc_menu = document.querySelector('#account')
	const acc_toggle = document.querySelector('#account-toggle')

	const async_items = document.querySelectorAll('.async-item')

	for( const item of async_items ){
		item.addEventListener('click', e => {
			e.preventDefault()
			let email, password, submit, br, modal, form
			switch( item.innerText ){

				case 'login':
					modal = new Modal({
						type: 'login',
					})
					form = document.createElement('form')
					email = document.createElement('input')
					email.placeholder = 'email'
					email.type = 'email'
					email.name = 'email'
					password = document.createElement('input')
					password.placeholder = 'password'
					password.type = 'password'
					password.name = 'password'
					br = document.createElement('br')
					submit = document.createElement('input')
					submit.classList.add('button')
					submit.type = 'submit'
					submit.value = 'login'
					form.addEventListener('submit', e => {
						e.preventDefault()
						const em = email.value.trim()
						const p = password.value.trim()
						if( !em || !p ){
							hal('error', 'missing values', 2000 )
							return
						}
						fetch_wrap( env.PUBLIC_ROOT + '/server/ajax/login.php', 'post', {
							email: em,
							password: p,
						})
						.then( res => {
							if( res.success ){
								location.assign( env.PUBLIC_ROOT )
							}else{
								let time
								time = res.msg.match(/not confirmed/) ? false : 5000
								hal('error', res.msg || 'error logging in', time )
								console.log( res )
							}
						})
						.catch( err => {
							hal('error', err.msg || 'error logging in', 5000 )
							console.log( err )
						})
					})
					const forgot = document.createElement('a')
					forgot.innerText= 'forgot password'
					forgot.href = '#'
					forgot.addEventListener('click', () => {
						forgot.href = env.PUBLIC_ROOT + '/server/reset_request.php?e=' + email.value.trim()
					})
					form.appendChild( email )
					form.appendChild( password )
					form.appendChild( br )
					form.appendChild( submit )
					form.appendChild( br.cloneNode() )
					form.appendChild( forgot )
					modal.content.appendChild( form )
					document.body.appendChild( modal.ele )
					break;

				case 'register':
					modal = new Modal({
						type: 'register',
					})
					email = document.createElement('input')
					email.placeholder = 'email'
					email.type = 'email'
					password = document.createElement('input')
					password.placeholder = 'password'
					password.type = 'password'
					const password_confirm = document.createElement('input')
					password_confirm.placeholder = 'password confirm'
					password_confirm.type = 'password'
					br = document.createElement('br')
					submit = document.createElement('input')
					submit.classList.add('button')
					submit.type = 'submit'
					submit.value = 'register'
					submit.addEventListener('click', () => {
						const e = email.value.trim()
						const p = password.value.trim()
						const pc = password.value.trim()
						if( !p || p !== pc ){
							hal('error', 'password mismatch', 3000 )
							return
						}
						fetch_wrap( env.PUBLIC_ROOT + '/server/ajax/register.php', 'post', {
							email: e,
							password: p,
							name: '',
						})
						.then( res => {
							if( res.success ){
								window.location.assign( env.PUBLIC_ROOT + '/server/confirm_code.php?e=' + e )
							}else{
								hal('error', res.msg || 'error registering', 5000 )
								console.log( res )
							}
						})
						.catch( err => {
							hal('error', err.msg || 'error registering', 5000 )
							console.log( err )
						})
					})
					lib.add_submit( email, submit )
					lib.add_submit( password, submit )
					lib.add_submit( password_confirm, submit )
					modal.content.appendChild( email )
					modal.content.appendChild( password )
					modal.content.appendChild( password_confirm )
					modal.content.appendChild( br )
					modal.content.appendChild( submit )
					document.body.appendChild( modal.ele )
					break;

				case 'create':	
					// modal...
					break;

				case 'account':
					break;

				case 'logout':
					fetch_wrap( env.PUBLIC_ROOT + '/server/ajax/logout.php', 'post', {} )
					.then( res => {
						if( res.success ){
							location.assign( env.PUBLIC_ROOT )
						}else{
							hal('error', res.msg || 'error logging out', 5000 )
							console.log( res )
						}
					})
					.catch( err => {
						hal('error', err.msg || 'error logging out', 5000 )
						console.log( err )
					})
					break;

				default: break;
			}
		})
	}	

	nav_toggle.addEventListener('click', () => {
		if( nav_menu.classList.contains('toggled') ){ // for mobile
			nav_menu.classList.remove('toggled')
		}else{
			nav_menu.classList.add('toggled')
		}
	})

	nav_toggle.addEventListener('mouseover', () => {
		nav_menu.classList.add('toggled')
	})

	nav_toggle.addEventListener('mouseout', () => {
		nav_menu.classList.remove('toggled')
	})


	acc_toggle.addEventListener('click', () => {
		if( acc_menu.classList.contains('toggled') ){ // for mobile
			acc_menu.classList.remove('toggled')
		}else{
			acc_menu.classList.add('toggled')
		}
	})

	acc_toggle.addEventListener('mouseover', () => {
		acc_menu.classList.add('toggled')
	})

	acc_toggle.addEventListener('mouseout', () => {
		acc_menu.classList.remove('toggled')
	})

}



export default init