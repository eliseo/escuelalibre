	<script src="http://widgets.twimg.com/j/2/widget.js"></script>
	<script>
	new TWTR.Widget({
	  version: 2,
	  type: 'profile',
	  rpp: 4,
	  interval: 6000,
	  width: 'auto',
	  height: 300,
	  theme: {
	    shell: {
	      background: '#0a5c7c',
	      color: '#ffffff'
	    },
	    tweets: {
	      background: '#ffffff',
	      color: '#565656',
	      links: '#305b7f'
	    }
	  },
	  features: {
	    scrollbar: false,
	    loop: false,
	    live: false,
	    hashtags: true,
	    timestamp: true,
	    avatars: false,
	    behavior: 'all'
	  }
	}).render().setUser('waterhouse_mx').start();
	</script>