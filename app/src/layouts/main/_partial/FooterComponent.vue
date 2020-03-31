<template>
  <footer class="footer">
    <div class="container">
      <ul class="info__links">
        <li v-for="link in links" :key="`link#${ link.id }`">
          <a :href="link.href" class="link">{{ link.label }}</a>
        </li>
      </ul>
      <span>&copy; GeekGram {{ getCurrentYear }}</span>
    </div>
  </footer>
</template>

<script>
  export default {
    data() {
      return {
        links: [
          { id: 1, label:'link1', href: '#' },
          { id: 2, label:'link2', href: '#' },
          { id: 3, label:'link3', href: '#' },
        ]
      }
    },
    name: "FooterComponent",
    components: {
    },
    computed: {
      getCurrentYear() {
        return new Date().getFullYear();
      },
    }
  };
</script>

<style lang="scss">

  footer.footer {
    padding: 0 20px;
    background-color: rgba(var(--b3f,250,250,250),1);

    .container {
      max-width: 1012px;
      padding: 40px 0;

      .info__links {
        display: flex;
        margin-bottom: 3px;
        margin-right: 16px;
        list-style: none;

        .link {
          color: #003569;
          font-weight: 600;
          line-height: 18px;
          font-size: 12px;
          text-transform: uppercase;
          display: inline-block;
          margin-bottom: 7px;
          margin-right: 16px;
        }
      }
    }
  }
</style>