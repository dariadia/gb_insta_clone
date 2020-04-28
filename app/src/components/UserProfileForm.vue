<template>
  <div class="form__container">
    <div class="profile__form">

      <div class="input__group flex">
        <label class="label">
          <font-awesome-icon v-if="!getPhotoPath()" class="photo_icon" :icon="['fas', 'user-circle']"/>
          <img v-else :src="getPhotoPath()"/>
        </label>
        <div class="content">
          <div class="username">{{ username.value || 'Не заданно' }}</div>
          <div class="link" @click="$refs.file.click()">Сменить фото профиля</div>
          <input type="file" ref="file" :value="file" v-on:change="handleUploadFile" hidden>
        </div>
      </div>

      <div class="input__group flex">
        <label class="label" :for="name.key">{{ name.label }}</label>
        <div class="content">
          <input type="text"
             :id="name.key"
             v-model="name.value"
             :placeholder="name.label"
             @input="( event ) => validateField( name.key, event )"
          />
        </div>
      </div>

      <div class="input__group flex">
        <label class="label" :for="username.key">{{ username.label }}</label>
        <div class="content">
          <input type="text"
              :id="username.key"
              v-model="username.value"
              :placeholder="username.label"
               @input="( event ) => validateField( username.key, event )"
          />
        </div>
      </div>

      <div class="input__group flex">
        <label class="label" :for="site.key">{{ site.label }}</label>
        <div class="content">
          <input type="text"
             :id="site.key"
             v-model="site.value"
             :placeholder="site.label"
             @input="( event ) => validateField( site.key, event )"
          />
        </div>
      </div>

      <div class="input__group flex">
        <label class="label" :for="about.key">{{ about.label }}</label>
        <div class="content">
          <textarea type="text" class="materialize-textarea"
              :id="about.key"
              v-model="about.value"
              :placeholder="about.label"
              @input="( event ) => validateField( site.key, event)"
          />
        </div>
      </div>
    </div>

    <div class="flex center">
      <button :disabled="!isValid" class="waves-effect waves-light btn-small orange darken-4">Отправить</button>
    </div>
  </div>

</template>


<script>
    import { uploadPhoto } from "../vuex/modules/profileModule/actions/uploadPhoto";
    import { doValidateByRules } from "../common/validators";


    export default {
        name: "UserProfileForm",

        data() {
            const { username, name, about, site } = this.$store.getters[ 'personalData' ];
            return {
                file: null, isValid: true, isLoading: true, updatedProfile: {},
                username: {
                    key: 'username', valid: true, value: username, label: 'Имя пользователя',
                    error: null, rules: { required: true }
                },
                name: { key: 'name', valid: true, value: name, label: 'Имя', error: null, rules: { required: true }
                },
                about: { key: 'about', valid: true, value: about, label: 'О себе', error: null },
                site: { key: 'site', valid: true, value: site, label: 'Веб-сайт', error: null },
            }
        },

        methods: {
            handleUploadFile( event ) {
                const { target: { files } } = event;
                uploadPhoto( files );
            },
            /** @todo доделать в следующей ветке */
            getPhotoPath() {
                return false;
            },
            validateField( key, event ) {
                const { rules } = this[ key ];
                const { target: { value } } = event;

                this.isValid = doValidateByRules( value, rules );
                this[ key ].value = value;
                this[ key ].isValid = this.isValid;
            },
        },
    }
</script>

<style lang="scss">

  .flex {
    display: flex;
    &.center {
      justify-content: center;
    }
  }

  .form__container {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    height: 100%;
  }

  .profile__form {
    .input__group {
      margin-bottom: 16px;
      &.flex {
        display: flex;
        align-items: center;
      }
      .label {
        text-align: right;
        width: 20%;
        margin-right: 5%;
      }
      .content {
        flex-grow: 1;

        .username {
          font-size: 20px;
          line-height: 22px;
          margin-bottom: 2px;
          overflow: hidden;
          text-overflow: ellipsis;
          white-space: nowrap;
          color: #7d7d7d;
        }

        .link {
          color: #0095f6;
          font-weight: bold;
          cursor: pointer;
          transition: color 0.5s;

          &:hover {
            color: #0483d4;
          }
        }
      }
    }
  }

  .photo_icon {
    color: #7d7d7d;
    transform: scale( 3 );
  }
</style>