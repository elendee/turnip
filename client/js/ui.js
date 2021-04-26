import env from './env.js?v=9'
import hal from './hal.js?v=9'

let spinning = false

class Spinner{

	constructor( init ){
		init = init || {}
		this.ele = init.ele || document.createElement('div')
		this.ele.classList.add('spinner')
		this.img = init.img || document.createElement('img')
		this.img.src = this.img.src || init.src
		this.ele.appendChild( this.img )

		document.body.appendChild( this.ele )
	}

	show( ele ){
		if( ele ){
			ele.appendChild( this.ele )
		}else{
			document.body.appendChild( this.ele )
		}
		this.ele.style.display = 'flex'
		if( spinning ){
			clearTimeout(spinning)
			spinning = false
		}
		spinning = setTimeout(()=>{
			clearTimeout(spinning)
			spinning = false
		}, 10 * 1000)
	}
	hide(){
		this.ele.remove()
		// this.ele.style.display = 'none'
	}
}


const spinner = new Spinner({
	src: env.PUBLIC_ROOT + '/resource/media/spinner.gif'
})


const reject = ( res, msg, time ) => {
	hal('error', msg, time )
	spinner.hide()
	if( res ) console.log( res )
}



export default {
	spinner,
	reject,
}


