import env from './env.js?v=6'

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






export default {
	spinner,
}


