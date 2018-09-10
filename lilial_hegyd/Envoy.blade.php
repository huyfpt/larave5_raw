@setup
    if($server == ""){
        echo "######################################################################################";
        echo "No server specified to connect to (--server='integration_continue@example.server.tld')";
        echo "######################################################################################";
        die();
    }

    if($project == ""){
        echo "###########################################################";
        echo "No project defined. Exiting... (--project='projectExample')";
        echo "###########################################################";
        die();
    }

    if($rootFolder == ""){
        $rootFolder = "/var/projects/recette/";
        echo "##############################################################################################################";
        echo "No root folder, use the default « $rootFolder ». Override the default value with « --rootFolder='/var/www/' »";
        echo "##############################################################################################################";
    }

    if($repository == ''){
        echo "####################################################################################";
        echo "No repository specified (--repository='git@gitlab.hegyd.net:hegyd/base-project.git')";
        echo "####################################################################################";
        die();
    }

    $releases_dir = $rootFolder . $project .'/releases';
    $app_dir = $rootFolder . $project;
    $release = date('YmdHis');
    $new_release_dir = $releases_dir .'/'. $release;
    $shared_dir = $app_dir . '/' . "shared";
@endsetup

@servers(['web' => $server])

@story('deploy')
    clone_repository
    run_dep
    update_symlinks
    run_migrate
    cleanup_release
@endstory

@story('deploy_graph')
    clone_repository
    run_dep
    update_symlinks
    run_migrate
    work_branch
@endstory
@task('clone_repository')
    echo 'Cloning repository'
    echo '{{$releases_dir}}'
    echo '{{$repository}}'
    [ -d {{ $releases_dir }} ] || mkdir -p {{ $releases_dir }}
    git clone {{ $repository }} {{ $new_release_dir }}
    cd {{ $new_release_dir }}
    git reset --hard {{ $commithash }}
@endtask

@task('cleanup_release')
    echo "Cleanup old release"
    cd "{{ $releases_dir }}"
    ls -dt */ | tail -n +3 | xargs rm -rf
@endtask

@task('run_dep')
    echo "Starting deployment ({{ $release }})"
    cd {{ $new_release_dir }}

    composer install --prefer-dist --no-scripts -q -o

    echo "Run Bower install"
    bower install --config.interactive=false

    echo "Run npm stage"
    npm install
    npm run dev
@endtask

@task('update_symlinks')
    echo "Create Shared folder"
    [ -d {{ $shared_dir }} ] || mkdir -p {{ $shared_dir }}
    [ -d {{ $shared_dir }}/storage ] || mkdir -p {{ $shared_dir }}/storage

    if [[ ! -f {{ $shared_dir }}/.env ]]; then
        echo ""
        echo "<fg=red>#########################################################################</>"
        echo "[<fg=red>✗</>]<fg=red>Please create the .env for the target environement in « shared » dir.</>"
        echo "<fg=red>#########################################################################</>"
        echo ""
    else
        echo 'Linking .env file'
        ln -nfs {{ $shared_dir }}/.env {{ $new_release_dir }}/.env
    fi

    echo "Linking storage directory"
    rm -rf {{ $new_release_dir }}/storage
    ln -nfs {{ $shared_dir }}/storage {{ $new_release_dir }}/storage

    echo 'Linking current release'
    ln -nfs {{ $new_release_dir }} {{ $app_dir }}/current
@endtask

@task('run_migrate')
    echo "Run Migrate ({{ $release }})"
    cd {{ $new_release_dir }}
    mkdir -p bootstrap/cache
    mkdir -p storage/app
    mkdir -p storage/logs
    mkdir -p storage/framework
    mkdir -p storage/framework/{sessions,views,cache}
    chown :www-data storage bootstrap -R || true
    chmod 775 storage/app -R || true
    chmod 777 storage/framework bootstrap/cache storage/logs -R || true

    if [[ ! -f {{ $shared_dir }}/.env ]]; then
        echo "Ignoring project migration"
    else
        composer dumpautoload
        php artisan migrate

        if [ -n "{{$seed}}" ] && [ "{{$seed}}" = "1" ]
        then
            echo "Db Seed"
            php artisan db:seed
        fi

        echo "Queue restart"
        php artisan queue:restart || true

        echo "Assets update"
        new_date=`date '+%Y%m%d_%H%M'`
        if grep -q ASSETS_REV= .env; then
            echo "[ASSETS] Updating to : $new_date"
            sed -i -r --follow-symlinks "s/^ASSETS_REV=[0-9]*_[0-9]*$/ASSETS_REV=$new_date/g" .env
        else
            echo "[ASSETS] Adding absent ASSETS_REV to the end of the .env file : $new_date"
            echo -e "\n\n# Assets revision number to add as suffix to each JS and CSS public files to force browsers cache" >> .env
            echo -e "ASSETS_REV=$new_date" >> .env
        fi
    fi
@endtask

@task('work_branch')
    echo "Create a new branch from commit hash {{$commithash}}"
    cd {{ $new_release_dir }}
    new_date=`date '+%Y%m%d_%H%M'`
    git checkout -b graph_$new_date
@endtask