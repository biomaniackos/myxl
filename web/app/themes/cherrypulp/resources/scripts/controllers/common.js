import { createApp } from "vue/dist/vue.esm-bundler";
import SlimSelect from "slim-select";
import AOS from "aos";
import "aos/dist/aos.css";

export default {
  mounted() {
    const app = createApp({
      mounted() {
        document.body.classList.add("initialized");

        // @see https://michalsnik.github.io/aos/
        AOS.init();

        const selects = document.querySelectorAll(".select");
        if (selects && selects.length > 0) {
          selects.forEach((el) => {
            new SlimSelect({
              select: el,
              allowDeselectOption: true,
            });
          });
        }
      },
    });

    app.mount(".app");
  },
};
