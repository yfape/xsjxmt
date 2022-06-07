import Vue from 'vue';
// import Vuetify from 'vuetify/lib';

import Vuetify,{
	VRow,VCol,VTextField,VBtn,
	VCarousel,VCarouselItem,VImg,
	VBottomNavigation,VIcon,VOverlay,
	VProgressCircular,VBottomSheet,VSheet,VFooter
} from 'vuetify/lib';

Vue.use(Vuetify);

export default new Vuetify({
	components:{VRow,VCol,VTextField,VBtn,
	VCarousel,VCarouselItem,VImg,
	VBottomNavigation,VIcon,VOverlay,
	VProgressCircular,VBottomSheet,VSheet,VFooter}
});
