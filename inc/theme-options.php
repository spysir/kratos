<?php

/**
 * 主题选项
 * @author Seaton Jiang <seatonjiang@vtrois.com>
 * @license GPL-3.0 License
 * @version 2021.08.20
 */

defined('ABSPATH') || exit;

$prefix = 'kratos_options';

if (!function_exists('kratos_option')) {
    function kratos_option($option = '', $default = null, $fieldset = '')
    {
        $options = get_option('kratos_options');

        if (!empty($fieldset)) {
            $results = $options[$fieldset][$option];
        } else {
            $results = $options[$option];
        }

        return (isset($results)) ? $results : $default;
    }
}

function getdomain($url)
{
    $rs = parse_url($url);
    if (!isset($rs['host'])) {
        return null;
    }

    $main_url = $rs['host'];
    if (!strcmp(long2ip(sprintf('%u', ip2long($main_url))), $main_url)) {
        return $main_url;
    } else {
        $arr = explode('.', $main_url);
        $count = count($arr);
        $endArr = array('com', 'net', 'org');
        if (in_array($arr[$count - 2], $endArr)) {
            $domain = $arr[$count - 3] . '.' . $arr[$count - 2] . '.' . $arr[$count - 1];
        } else {
            $domain = $arr[$count - 2] . '.' . $arr[$count - 1];
        }
        return $domain;
    }
}

function getrobots()
{
    $site_url = parse_url(site_url());
    $web_url = get_bloginfo('url');
    $path = (!empty($site_url['path'])) ? $site_url['path'] : '';

    $robots = "User-agent: *\n\n";
    $robots .= "Disallow: $path/wp-admin/\n";
    $robots .= "Disallow: $path/wp-includes/\n";
    $robots .= "Disallow: $path/wp-content/plugins/\n";
    $robots .= "Disallow: $path/wp-content/themes/\n\n";
    $robots .= "Sitemap: $web_url/wp-sitemap.xml\n";

    return $robots;
}

CSF::createOptions($prefix, array(
    'menu_title' => __('主题设置', 'kratos'),
    'menu_slug' => 'kratos-options',
    'show_bar_menu' => false,
    'framework_title' => '主题设置<small style="margin-left:10px">Kratos v' . THEME_VERSION . '</small>',
    'theme' => 'light',
    'footer_credit' => '感谢使用 <a target="_blank" href="https://github.com/vtrois/kratos">Kratos</a> 主题开始创作，欢迎加入交流群：<a target="_blank" href="https://qm.qq.com/cgi-bin/qm/qr?k=jHy4nvMcnurowkL602BTDZzverAqfTpI&jump_from=webapi">734508</a>',
));

CSF::createSection($prefix, array(
    'id' => 'global_fields',
    'title' => __('全站配置', 'kratos'),
    'icon' => 'fas fa-rocket',
));

CSF::createSection($prefix, array(
    'parent' => 'global_fields',
    'title' => __('功能配置', 'kratos'),
    'icon' => 'fas fa-arrow-right',
    'fields' => array(
        array(
            'id' => 'g_adminbar',
            'type' => 'switcher',
            'title' => __('前台管理员导航', 'kratos'),
            'subtitle' => __('启用/禁用前台管理员导航', 'kratos'),
            'default' => true,
        ),
        array(
            'id' => 'g_login',
            'type' => 'switcher',
            'title' => __('侧边栏后台入口', 'kratos'),
            'subtitle' => __('启用/禁用个人简介头像进入后台功能', 'kratos'),
            'default' => true,
        ),
        array(
            'id' => 'g_sticky',
            'type' => 'switcher',
            'title' => __('侧边栏随动', 'kratos'),
            'subtitle' => __('启用/禁用小工具侧边栏随动功能', 'kratos'),
            'default' => false,
        ),
        array(
            'id' => 'g_search',
            'type' => 'switcher',
            'title' => __('搜索增强', 'kratos'),
            'subtitle' => __('启用/禁用仅搜索文章标题', 'kratos'),
            'default' => false,
        ),
        array(
            'id' => 'g_thumbnail',
            'type' => 'switcher',
            'title' => __('特色图片', 'kratos'),
            'subtitle' => __('启用/禁用文章特色图片', 'kratos'),
            'default' => true,
        ),
        array(
            'id' => 'g_rip',
            'type' => 'switcher',
            'title' => __('哀悼功能', 'kratos'),
            'subtitle' => __('启用/禁用站点首页黑白功能', 'kratos'),
            'default' => false,
        ),
        array(
            'id' => 'g_animate',
            'type' => 'switcher',
            'title' => __('CSS 动画库', 'kratos'),
            'subtitle' => __('启用/禁用 animate.css 效果', 'kratos'),
            'default' => false,
        ),
        array(
            'id' => 'g_fontawesome',
            'type' => 'switcher',
            'title' => __('Font Awesome', 'kratos'),
            'subtitle' => __('启用/禁用 Font Awesome Free 字体', 'kratos'),
            'default' => false,
        ),
        array(
            'id' => 'g_cdn',
            'type' => 'switcher',
            'title' => __('静态资源加速', 'kratos'),
            'subtitle' => __('启用/禁用静态资源加速', 'kratos'),
            'default' => true,
        ),
        array(
            'id' => 'g_gravatar',
            'type' => 'switcher',
            'title' => __('Gravatar 加速', 'kratos'),
            'subtitle' => __('启用/禁用 Gravatar 头像加速', 'kratos'),
            'default' => true,
        ),
        array(
            'id' => 'g_renameimg',
            'type' => 'switcher',
            'title' => __('自定义图片类型的文件名', 'kratos'),
            'subtitle' => __('启用/禁用 图片类型的文件名改为 MD5 值', 'kratos'),
            'default' => false,
        ),
        array(
            'id' => 'g_removeimgsize',
            'type' => 'switcher',
            'title' => __('禁止生成缩略图', 'kratos'),
            'subtitle' => __('启用/禁用生成多种尺寸图片资源', 'kratos'),
            'default' => false,
        ),
        array(
            'id' => 'g_gutenberg',
            'type' => 'switcher',
            'title' => __('Gutenberg 编辑器', 'kratos'),
            'subtitle' => __('启用/禁用 Gutenberg 编辑器', 'kratos'),
            'default' => false,
        ),
        array(
            'id' => 'g_renameother_fieldset',
            'type' => 'fieldset',
            'fields' => array(
                array(
                    'type' => 'subheading',
                    'content' => __('附件重命名', 'kratos'),
                ),
                array(
                    'id' => 'g_renameother',
                    'type' => 'switcher',
                    'title' => __('功能开关', 'kratos'),
                    'subtitle' => __('开启/关闭附件重命名', 'kratos'),
                    'text_on' => __('开启', 'kratos'),
                    'text_off' => __('关闭', 'kratos'),
                ),
                array(
                    'id' => 'g_renameother_prdfix',
                    'type' => 'text',
                    'title' => __('文件前缀', 'kratos'),
                    'subtitle' => __('前缀与文件名之间会用 - 连接', 'kratos'),
                ),
                array(
                    'id' => 'g_renameother_mime',
                    'type' => 'text',
                    'title' => __('文件类型', 'kratos'),
                    'subtitle' => __('每个类型之间用 | 隔开', 'kratos'),
                ),
            ),
            'default' => array(
                'g_renameother' => false,
                'g_renameother_prdfix' => getdomain(home_url()),
                'g_renameother_mime' => 'tar|zip|gz|gzip|rar|7z',
            ),
        ),
        array(
            'id' => 'g_wechat_fieldset',
            'type' => 'fieldset',
            'fields' => array(
                array(
                    'type' => 'subheading',
                    'content' => __('微信二维码', 'kratos'),
                ),
                array(
                    'id' => 'g_wechat',
                    'type' => 'switcher',
                    'title' => __('功能开关', 'kratos'),
                    'subtitle' => __('开启/关闭微信二维码', 'kratos'),
                    'text_on' => __('开启', 'kratos'),
                    'text_off' => __('关闭', 'kratos'),
                ),
                array(
                    'id' => 'g_wechat_url',
                    'type' => 'upload',
                    'title' =>  __('二维码图片', 'kratos'),
                    'library' => 'image',
                    'preview' => true,
                    'subtitle' => __('浮动显示在页面右下角', 'kratos'),
                ),
            ),
            'default' => array(
                'g_wechat' => false,
                'g_wechat_url' => get_template_directory_uri() . '/assets/img/wechat.png',
            ),
        ),
    ),
));

CSF::createSection($prefix, array(
    'parent' => 'global_fields',
    'title' => __('颜色配置', 'kratos'),
    'icon' => 'fas fa-arrow-right',
    'fields' => array(
        array(
            'id' => 'g_background',
            'type' => 'color',
            'default' => '#f5f5f5',
            'title' =>  __('全站背景颜色', 'kratos'),
            'subtitle' => __('全站页面的背景颜色', 'kratos'),
        ),
        array(
            'id' => 'g_chrome',
            'type' => 'color',
            'default' => '#282a2c',
            'title' =>  __('Chrome 导航栏颜色', 'kratos'),
            'subtitle' => __('移动端 Chrome 浏览器导航栏颜色', 'kratos'),
        ),
    ),
));

CSF::createSection($prefix, array(
    'parent' => 'global_fields',
    'title' => __('图片配置', 'kratos'),
    'icon' => 'fas fa-arrow-right',
    'fields' => array(
        array(
            'id' => 'g_logo',
            'type' => 'upload',
            'title' => __('站点 Logo', 'kratos'),
            'library' => 'image',
            'preview' => true,
            'subtitle' => __('不上传图片则显示站点标题', 'kratos'),
        ),
        array(
            'id' => 'g_icon',
            'type' => 'upload',
            'title' =>  __('Favicon 图标', 'kratos'),
            'library' => 'image',
            'preview' => true,
            'subtitle' => __('浏览器收藏夹和地址栏中显示的图标', 'kratos'),
        ),
        array(
            'id' => 'g_404',
            'type' => 'upload',
            'title' =>  __('404 页面图片', 'kratos'),
            'library' => 'image',
            'preview' => true,
            'default' => get_template_directory_uri() . '/assets/img/404.jpg',
            'subtitle' => __('图片显示出来是 404 的形状', 'kratos'),
        ),
        array(
            'id' => 'g_nothing',
            'type' => 'upload',
            'title' =>  __('无内容图片', 'kratos'),
            'library' => 'image',
            'preview' => true,
            'default' => get_template_directory_uri() . '/assets/img/nothing.svg',
            'subtitle' => __('当搜索不到文章或分类没有文章时显示', 'kratos'),
        ),
        array(
            'id' => 'g_postthumbnail',
            'type' => 'upload',
            'title' =>  __('默认特色图', 'kratos'),
            'library' => 'image',
            'preview' => true,
            'default' => get_template_directory_uri() . '/assets/img/default.jpg',
            'subtitle' => __('当文章中没有图片且没有特色图时显示', 'kratos'),
        ),
    ),
));

CSF::createSection($prefix, array(
    'parent' => 'global_fields',
    'title' => __('首页轮播', 'kratos'),
    'icon' => 'fas fa-arrow-right',
    'fields' => array(
        array(
            'id' => 'g_carousel',
            'type' => 'switcher',
            'title' => __('首页轮播', 'kratos'),
            'subtitle' => __('开启/关闭首页轮播功能', 'kratos'),
            'text_on' => __('开启', 'kratos'),
            'text_off' => __('关闭', 'kratos'),
            'default' => false,
        ),
        array(
            'id' => 'carousel_tabbed',
            'type' => 'tabbed',
            'tabs' => array(
                array(
                    'title' => '轮播一',
                    'fields' => array(
                        array(
                            'id' => 'c_i_1',
                            'type' => 'upload',
                            'title' => __('轮播图片', 'kratos'),
                            'library' => 'image',
                            'preview' => true,
                        ),
                        array(
                            'id' => 'c_u_1',
                            'type' => 'text',
                            'title' =>  __('网址链接', 'kratos'),
                        ),
                    ),
                ),
                array(
                    'title' => '轮播二',
                    'fields' => array(
                        array(
                            'id' => 'c_i_2',
                            'type' => 'upload',
                            'title' => __('轮播图片', 'kratos'),
                            'library' => 'image',
                            'preview' => true,
                        ),
                        array(
                            'id' => 'c_u_2',
                            'type' => 'text',
                            'title' =>  __('网址链接', 'kratos'),
                        ),
                    ),
                ),
                array(
                    'title' => '轮播三',
                    'fields' => array(
                        array(
                            'id' => 'c_i_3',
                            'type' => 'upload',
                            'title' => __('轮播图片', 'kratos'),
                            'library' => 'image',
                            'preview' => true,
                        ),
                        array(
                            'id' => 'c_u_3',
                            'type' => 'text',
                            'title' =>  __('网址链接', 'kratos'),
                        ),
                    ),
                ),
                array(
                    'title' => '轮播四',
                    'fields' => array(
                        array(
                            'id' => 'c_i_4',
                            'type' => 'upload',
                            'title' => __('轮播图片', 'kratos'),
                            'library' => 'image',
                            'preview' => true,
                        ),
                        array(
                            'id' => 'c_u_4',
                            'type' => 'text',
                            'title' =>  __('网址链接', 'kratos'),
                        ),
                    ),
                ),
                array(
                    'title' => '轮播五',
                    'fields' => array(
                        array(
                            'id' => 'c_i_5',
                            'type' => 'upload',
                            'title' => __('轮播图片', 'kratos'),
                            'library' => 'image',
                            'preview' => true,
                        ),
                        array(
                            'id' => 'c_u_5',
                            'type' => 'text',
                            'title' =>  __('网址链接', 'kratos'),
                        ),
                    ),
                ),
            ),
        ),
    )
));

CSF::createSection($prefix, array(
    'parent' => 'global_fields',
    'title' => __('第三方配置', 'kratos'),
    'icon' => 'fas fa-arrow-right',
    'fields' => array(
        array(
            'id' => 'g_cos_fieldset',
            'type' => 'fieldset',
            'fields' => array(
                array(
                    'type' => 'subheading',
                    'content' => __('DogeCloud 云存储', 'kratos'),
                ),
                array(
                    'type' => 'submessage',
                    'style' => 'info',
                    'content' => 'DogeCloud 云存储提供<strong> 10 GB </strong>的免费存储额度，<strong> 20 GB </strong>每月的免费 CDN 额度，<a target="_blank" href="https://console.dogecloud.com/register.html?iuid=614">立即注册</a>',
                ),
                array(
                    'id' => 'g_cos',
                    'type' => 'switcher',
                    'title' => __('功能开关', 'kratos'),
                    'subtitle' => __('开启/关闭 DogeCloud 云存储', 'kratos'),
                    'text_on' => __('开启', 'kratos'),
                    'text_off' => __('关闭', 'kratos'),
                ),
                array(
                    'id' => 'g_cos_bucketname',
                    'type' => 'text',
                    'title' => __('空间名称', 'kratos'),
                    'subtitle' => __('空间名称可在空间基本信息中查看', 'kratos'),
                    'desc' => __('<a target="_blank" href="https://console.dogecloud.com/oss/list">点击这里</a>查询空间名称', 'kratos'),
                ),
                array(
                    'id' => 'g_cos_url',
                    'type' => 'text',
                    'title' => __('加速域名', 'kratos'),
                    'subtitle' => __('域名结尾不要添加 /', 'kratos'),
                    'desc' => __('<a target="_blank" href="https://console.dogecloud.com/oss/list">点击这里</a>查询加速域名', 'kratos'),
                ),
                array(
                    'id' => 'g_cos_accesskey',
                    'type' => 'text',
                    'title' => __('AccessKey', 'kratos'),
                    'subtitle' => __('出于安全考虑，建议周期性地更换密钥', 'kratos'),
                    'desc' => __('<a target="_blank" href="https://console.dogecloud.com/user/keys">点击这里</a>查询 AccessKey', 'kratos'),
                ),
                array(
                    'id' => 'g_cos_secretkey',
                    'type' => 'text',
                    'attributes' => array(
                        'type' => 'password',
                    ),
                    'title' => __('SecretKey', 'kratos'),
                    'subtitle' => __('出于安全考虑，建议周期性地更换密钥', 'kratos'),
                    'desc' => __('<a target="_blank" href="https://console.dogecloud.com/user/keys">点击这里</a>查询 SecretKey', 'kratos'),
                ),
            ),
            'default' => array(
                'g_cos' => false,
            ),
        ),
        array(
            'id' => 'g_imgx_fieldset',
            'type' => 'fieldset',
            'fields' => array(
                array(
                    'type' => 'subheading',
                    'content' => __('火山引擎 ImageX', 'kratos'),
                ),
                array(
                    'type' => 'submessage',
                    'style' => 'info',
                    'content' => '火山引擎 ImageX 提供<strong> 10 GB </strong>的免费存储额度，<strong> 10 GB </strong>每月的免费 CDN 额度，<strong> 20 TB </strong>每月的图像处理额度，<a target="_blank" href="https://www.volcengine.com/products/imagex?utm_content=ImageX&utm_medium=i4vj9y&utm_source=u7g4zk&utm_term=ImageX-kratos">立即注册</a>',
                ),
                array(
                    'id' => 'g_imgx',
                    'type' => 'switcher',
                    'title' => __('功能开关', 'kratos'),
                    'subtitle' => __('开启/关闭 火山引擎 ImageX', 'kratos'),
                    'text_on' => __('开启', 'kratos'),
                    'text_off' => __('关闭', 'kratos'),
                ),
                array(
                    'id' => 'g_imgx_region',
                    'type' => 'select',
                    'title' => __('加速地域', 'kratos'),
                    'subtitle' => __('加速地域在创建服务的时候进行选择', 'kratos'),
                    'desc' => __('<a target="_blank" href="https://console.volcengine.com/imagex/service_manage/">点击这里</a>查询加速地域', 'kratos'),
                    'options' => array(
                        'cn-north-1' => __('国内', 'kratos'),
                        'us-east-1' => __('美东', 'kratos'),
                        'ap-singapore-1' => __('新加坡', 'kratos')
                    ),
                ),
                array(
                    'id' => 'g_imgx_serviceid',
                    'type' => 'text',
                    'title' => __('服务 ID', 'kratos'),
                    'subtitle' => __('服务 ID 可在图片服务管理中查看', 'kratos'),
                    'desc' => __('<a target="_blank" href="https://console.volcengine.com/imagex/service_manage/">点击这里</a>查询服务 ID', 'kratos'),
                ),
                array(
                    'id' => 'g_imgx_url',
                    'type' => 'text',
                    'title' => __('加速域名', 'kratos'),
                    'subtitle' => __('域名结尾不要添加 /', 'kratos'),
                    'desc' => __('<a target="_blank" href="https://console.volcengine.com/imagex/service_manage/">点击这里</a>查询加速域名', 'kratos'),
                ),
                array(
                    'id' => 'g_imgx_tmp',
                    'type' => 'text',
                    'title' => __('处理模板', 'kratos'),
                    'subtitle' => __('处理模板可在图片处理配置中查看', 'kratos'),
                    'desc' => __('<a target="_blank" href="https://console.volcengine.com/imagex/image_template/">点击这里</a>查询处理模板', 'kratos'),
                ),
                array(
                    'id' => 'g_imgx_accesskey',
                    'type' => 'text',
                    'title' => __('AccessKey', 'kratos'),
                    'subtitle' => __('出于安全考虑，建议周期性地更换密钥', 'kratos'),
                    'desc' => __('<a target="_blank" href="https://console.volcengine.com/iam/keymanage/">点击这里</a>查询 AccessKey', 'kratos'),
                ),
                array(
                    'id' => 'g_imgx_secretkey',
                    'type' => 'text',
                    'attributes' => array(
                        'type' => 'password',
                    ),
                    'title' => __('SecretKey', 'kratos'),
                    'subtitle' => __('出于安全考虑，建议周期性地更换密钥', 'kratos'),
                    'desc' => __('<a target="_blank" href="https://console.volcengine.com/iam/keymanage/">点击这里</a>查询 SecretKey', 'kratos'),
                ),
            ),
            'default' => array(
                'g_imgx' => false,
                'g_imgx_region' => 'cn-north-1'
            ),
        ),
    ),
));

CSF::createSection($prefix, array(
    'title' => __('收录配置', 'kratos'),
    'icon' => 'fas fa-camera',
    'fields' => array(
        array(
            'id' => 'seo_shareimg',
            'type' => 'upload',
            'title' =>  __('分享图片', 'kratos'),
            'library' => 'image',
            'preview' => true,
            'default' => get_template_directory_uri() . '/assets/img/default.jpg',
            'subtitle' => __('用于搜索引擎或社交工具抓取时使用', 'kratos'),
        ),
        array(
            'id' => 'seo_keywords',
            'type' => 'text',
            'title' => __('关键词', 'kratos'),
            'subtitle' =>  __('每个关键词之间需要用 , 分割', 'kratos'),
        ),
        array(
            'id' => 'seo_description',
            'type' => 'textarea',
            'title' => __('站点描述', 'kratos'),
            'subtitle' =>  __('网站首页的描述信息', 'kratos'),
        ),
        array(
            'id' => 'seo_statistical',
            'title' => __('统计代码', 'kratos'),
            'subtitle' => __('<span style="color:red">输入代码时请注意辨别代码安全性</span>', 'kratos'),
            'type' => 'code_editor',
            'settings' => array(
                'theme' => 'default',
                'mode' => 'html',
            ),
            'sanitize' => false,
            'default' => '<script></script>',
        ),
        array(
            'id' => 'seo_robots_fieldset',
            'type' => 'fieldset',
            'fields' => array(
                array(
                    'type' => 'subheading',
                    'content' => __('robots.txt 配置', 'kratos'),
                ),
                array(
                    'type' => 'content',
                    'content' => '<ul> <li>' . __('- 需要 ', 'kratos') . '<a href="' . admin_url('options-reading.php') . '" target="_blank">' . __('设置-阅读-对搜索引擎的可见性', 'kratos') . '</a>' . __(' 是开启的状态，以下配置才会生效', 'kratos') . '</li><li>' . __('- 如果网站根目录下已经有 robots.txt 文件，下面的配置不会生效', 'kratos') . '</li><li>' . __('- 点击 ', 'kratos') . '<a href="' . home_url() . '/robots.txt" target="_blank">robots.txt</a>' . __(' 查看配置是否生效，如果网站开启了 CDN，可能需要刷新缓存才会生效', 'kratos') . '</li></ul>',
                ),
                array(
                    'id' => 'seo_robots',
                    'type' => 'textarea',
                ),
            ),
            'default' => array(
                'seo_robots' => getrobots(),
            ),
        ),
    ),
));

CSF::createSection($prefix, array(
    'title' => __('文章配置', 'kratos'),
    'icon' => 'fas fa-file-alt',
    'fields' => array(
        array(
            'id' => 'g_163mic',
            'type' => 'switcher',
            'title' => __('网易云音乐', 'kratos'),
            'subtitle' => __('启用/禁用网易云音乐自动播放功能', 'kratos'),
            'default' => false,
        ),
        array(
            'id' => 'g_post_revision',
            'type' => 'switcher',
            'title' => __('附加功能', 'kratos'),
            'subtitle' => __('启用/禁用文章自动保存、修订版本功能', 'kratos'),
            'default' => false,
        ),
        array(
            'id' => 'opt-image-select',
            'type' => 'image_select',
            'title' => __('页面布局', 'kratos'),
            'subtitle' => __('差异在于侧边栏小工具，仅在文章页面生效', 'kratos'),
            'options' => array(
                'one_side' => get_template_directory_uri() . '/assets/img/options/col-12.png',
                'two_side' => get_template_directory_uri() . '/assets/img/options/col-8.png',
            ),
            'default' => 'two_side',
        ),
        array(
            'id' => 'g_cc_fieldset',
            'type' => 'fieldset',
            'fields' => array(
                array(
                    'type' => 'subheading',
                    'content' => __('知识共享协议', 'kratos'),
                ),
                array(
                    'id' => 'g_cc_switch',
                    'type' => 'switcher',
                    'title' => __('功能开关', 'kratos'),
                    'subtitle' => __('开启/关闭 知识共享协议', 'kratos'),
                    'text_on' => __('开启', 'kratos'),
                    'text_off' => __('关闭', 'kratos'),
                ),
                array(
                    'id' => 'g_cc',
                    'type' => 'select',
                    'title' => __('协议名称', 'kratos'),
                    'subtitle' => __('选择文章的知识共享协议', 'kratos'),
                    'options' => array(
                        'one' => __('知识共享署名 4.0 国际许可协议', 'kratos'),
                        'two' => __('知识共享署名-非商业性使用 4.0 国际许可协议', 'kratos'),
                        'three' => __('知识共享署名-禁止演绎 4.0 国际许可协议', 'kratos'),
                        'four' => __('知识共享署名-非商业性使用-禁止演绎 4.0 国际许可协议', 'kratos'),
                        'five' => __('知识共享署名-相同方式共享 4.0 国际许可协议', 'kratos'),
                        'six' => __('知识共享署名-非商业性使用-相同方式共享 4.0 国际许可协议', 'kratos'),
                    ),
                ),
            ),
            'default' => array(
                'g_cc_switch' => false,
                'g_cc' => 'one',
            ),
        ),
        array(
            'id' => 'g_article_fieldset',
            'type' => 'fieldset',
            'fields' => array(
                array(
                    'type' => 'subheading',
                    'content' => __('文章 HOT 标签', 'kratos'),
                ),
                array(
                    'id' => 'g_article_comment',
                    'type' => 'text',
                    'title' => __('评论数', 'kratos'),
                    'subtitle' => __('填写显示 HOT 标签需要的评论数', 'kratos'),
                ),
                array(
                    'id' => 'g_article_love',
                    'type' => 'text',
                    'title' => __('点赞数', 'kratos'),
                    'subtitle' => __('填写显示 HOT 标签需要的点赞数', 'kratos'),
                ),
            ),
            'default' => array(
                'g_article_comment' => '20',
                'g_article_love' => '200',
            ),
        ),
        array(
            'id' => 'g_donate_fieldset',
            'type' => 'fieldset',
            'fields' => array(
                array(
                    'type' => 'subheading',
                    'content' => __('文章打赏', 'kratos'),
                ),
                array(
                    'id' => 'g_donate',
                    'type' => 'switcher',
                    'title' => __('功能开关', 'kratos'),
                    'subtitle' => __('开启/关闭 文章打赏', 'kratos'),
                    'text_on' => __('开启', 'kratos'),
                    'text_off' => __('关闭', 'kratos'),
                ),
                array(
                    'id' => 'g_donate_wechat',
                    'type' => 'upload',
                    'title' =>  __('微信二维码', 'kratos'),
                    'library' => 'image',
                    'preview' => true,
                ),
                array(
                    'id' => 'g_donate_alipay',
                    'type' => 'upload',
                    'title' =>  __('支付宝二维码', 'kratos'),
                    'library' => 'image',
                    'preview' => true,
                ),
            ),
            'default' => array(
                'g_donate' => false,
                'g_donate_wechat' => get_template_directory_uri() . '/assets/img/donate.png',
                'g_donate_alipay' => get_template_directory_uri() . '/assets/img/donate.png',
            ),
        ),
    ),
));

CSF::createSection($prefix, array(
    'title' =>  __('邮件配置', 'kratos'),
    'icon' => 'fas fa-envelope',
    'fields' => array(
        array(
            'id' => 'm_smtp',
            'type' => 'switcher',
            'title' => __('SMTP 服务', 'kratos'),
            'subtitle' => __('启用/禁用 SMTP 服务', 'kratos'),
            'default' => false,
        ),
        array(
            'id' => 'm_host',
            'type' => 'text',
            'title' => __('邮件服务器', 'kratos'),
            'subtitle' => __('填写发件服务器地址', 'kratos'),
            'placeholder' => __('smtp.example.com', 'kratos'),
        ),
        array(
            'id' => 'm_port',
            'type' => 'text',
            'title' => __('服务器端口', 'kratos'),
            'subtitle' => __('填写发件服务器端口', 'kratos'),
            'placeholder' => __('465', 'kratos'),
        ),
        array(
            'id' => 'm_sec',
            'type' => 'text',
            'title' => __('授权方式', 'kratos'),
            'subtitle' => __('填写登录鉴权的方式', 'kratos'),
            'placeholder' => __('ssl', 'kratos'),
        ),
        array(
            'id' => 'm_username',
            'type' => 'text',
            'title' => __('邮箱帐号', 'kratos'),
            'subtitle' => __('填写邮箱账号', 'kratos'),
            'placeholder' => __('user@example.com', 'kratos'),
        ),
        array(
            'id' => 'm_passwd',
            'type' => 'text',
            'title' => __('邮箱密码', 'kratos'),
            'subtitle' => __('填写邮箱密码', 'kratos'),
            'attributes' => array(
                'type' => 'password',
            ),
        ),
    ),
));

CSF::createSection($prefix, array(
    'id' => 'top_fields',
    'title' => __('顶部配置', 'kratos'),
    'icon' => 'fas fa-window-maximize',
));

CSF::createSection($prefix, array(
    'parent' => 'top_fields',
    'title' => __('图片导航', 'kratos'),
    'icon' => 'fas fa-arrow-right',
    'fields' => array(
        array(
            'id' => 'top_img_switch',
            'type' => 'switcher',
            'title' => __('图片导航', 'kratos'),
            'subtitle' => __('启用/禁用 图片导航', 'kratos'),
            'default' => true,
        ),
        array(
            'id' => 'top_img',
            'type' => 'upload',
            'title' =>  __('顶部图片', 'kratos'),
            'library' => 'image',
            'preview' => true,
            'default' => get_template_directory_uri() . '/assets/img/background.png',
        ),
        array(
            'id' => 'top_title',
            'type' => 'text',
            'title' => __('图片标题', 'kratos'),
            'default' => __('Kratos', 'kratos'),
        ),
        array(
            'id' => 'top_describe',
            'type' => 'text',
            'title' => __('标题描述', 'kratos'),
            'default' => __('一款专注于用户阅读体验的响应式博客主题', 'kratos'),
        ),
    ),
));

CSF::createSection($prefix, array(
    'parent' => 'top_fields',
    'title' => __('颜色导航', 'kratos'),
    'icon' => 'fas fa-arrow-right',
    'fields' => array(
        array(
            'id' => 'top_color',
            'type' => 'color',
            'default' => '#24292e',
            'title' =>  __('颜色导航', 'kratos'),
        ),
    ),
));

CSF::createSection($prefix, array(
    'id' => 'footer_fields',
    'title' => __('页脚配置', 'kratos'),
    'icon' => 'far fa-window-maximize',
));

CSF::createSection($prefix, array(
    'parent' => 'footer_fields',
    'title' => __('社交图标', 'kratos'),
    'icon' => 'fas fa-arrow-right',
    'fields' => array(
        array(
            'id' => 's_social_domestic_fieldset',
            'type' => 'fieldset',
            'fields' => array(
                array(
                    'type' => 'subheading',
                    'content' => __('国内平台', 'kratos'),
                ),
                array(
                    'id' => 's_sina_url',
                    'type' => 'text',
                    'title' => __('新浪微博', 'kratos'),
                    'placeholder' => __('https://weibo.com/xxxxx', 'kratos'),
                ),
                array(
                    'id' => 's_bilibili_url',
                    'type' => 'text',
                    'title' => __('哔哩哔哩', 'kratos'),
                    'placeholder' => __('https://space.bilibili.com/xxxxx', 'kratos'),
                ),
                array(
                    'id' => 's_coding_url',
                    'type' => 'text',
                    'title' => __('CODING', 'kratos'),
                    'placeholder' => __('https://xxxxx.coding.net/u/xxxxx', 'kratos'),
                ),
                array(
                    'id' => 's_gitee_url',
                    'type' => 'text',
                    'title' => __('码云', 'kratos'),
                    'placeholder' => __('https://gitee.com/xxxxx', 'kratos'),
                ),
                array(
                    'id' => 's_douban_url',
                    'type' => 'text',
                    'title' => __('豆瓣', 'kratos'),
                    'placeholder' => __('https://www.douban.com/people/xxxxx', 'kratos'),
                ),
            ),
        ),
        array(
            'id' => 's_social_overseas_fieldset',
            'type' => 'fieldset',
            'fields' => array(
                array(
                    'type' => 'subheading',
                    'content' => __('海外平台', 'kratos'),
                ),
                array(
                    'id' => 's_twitter_url',
                    'type' => 'text',
                    'title' => __('Twitter', 'kratos'),
                    'placeholder' => __('https://twitter.com/xxxxx', 'kratos'),
                ),
                array(
                    'id' => 's_telegram_url',
                    'type' => 'text',
                    'title' => __('Telegram', 'kratos'),
                    'placeholder' => __('https://t.me/xxxxx', 'kratos'),
                ),
                array(
                    'id' => 's_linkedin_url',
                    'type' => 'text',
                    'title' => __('LinkedIn', 'kratos'),
                    'placeholder' => __('https://www.linkedin.com/in/xxxxx', 'kratos'),
                ),
                array(
                    'id' => 's_youtube_url',
                    'type' => 'text',
                    'title' => __('YouTube', 'kratos'),
                    'placeholder' => __('https://www.youtube.com/channel/xxxxx', 'kratos'),
                ),
                array(
                    'id' => 's_github_url',
                    'type' => 'text',
                    'title' => __('Github', 'kratos'),
                    'placeholder' => __('https://github.com/xxxxx', 'kratos'),
                ),
                array(
                    'id' => 's_stackflow_url',
                    'type' => 'text',
                    'title' => __('Stack Overflow', 'kratos'),
                    'placeholder' => __('https://stackoverflow.com/users/xxxxx', 'kratos'),
                ),
            ),
        ),
        array(
            'id' => 's_social_domestic_fieldset',
            'type' => 'fieldset',
            'fields' => array(
                array(
                    'type' => 'subheading',
                    'content' => __('其他', 'kratos'),
                ),
                array(
                    'id' => 's_email_url',
                    'type' => 'text',
                    'title' => __('电子邮箱', 'kratos'),
                    'placeholder' => __('mailto:xxxxx@example.com', 'kratos'),
                ),
            ),
        ),
    ),
));

CSF::createSection($prefix, array(
    'parent' => 'footer_fields',
    'title' => __('备案信息', 'kratos'),
    'icon' => 'fas fa-arrow-right',
    'fields' => array(
        array(
            'id' => 's_icp',
            'type' => 'text',
            'title' => __('工信部备案信息', 'kratos'),
            'subtitle' => __('由<a target="_blank" href="https://beian.miit.gov.cn/">工业和信息化部政务服务平台</a>提供', 'kratos'),
            'placeholder' => __('冀ICP证XXXXXX号', 'kratos'),
        ),
        array(
            'id' => 's_gov',
            'type' => 'text',
            'title' => __('公安备案信息', 'kratos'),
            'subtitle' => __('由<a target="_blank" href="http://www.beian.gov.cn/">全国互联网安全管理服务平台</a>提供', 'kratos'),
            'placeholder' => __('冀公网安备 XXXXXXXXXXXXX 号', 'kratos'),
        ),
        array(
            'id' => 's_gov_link',
            'type' => 'text',
            'title' => __('公安备案链接', 'kratos'),
            'subtitle' => __('由<a target="_blank" href="http://www.beian.gov.cn/">全国互联网安全管理服务平台</a>提供', 'kratos'),
            'placeholder' => __('http://www.beian.gov.cn/portal/registerSystemInfo?recordcode=xxxxx', 'kratos'),
        ),
    ),
));

CSF::createSection($prefix, array(
    'parent' => 'footer_fields',
    'title' => __('版权信息', 'kratos'),
    'icon' => 'fas fa-arrow-right',
    'fields' => array(
        array(
            'id' => 's_copyright',
            'type' => 'textarea',
            'title' => __('版权信息', 'kratos'),
            'default' => 'COPYRIGHT © ' . date('Y') . ' ' . getdomain(home_url()) . '. ALL RIGHTS RESERVED.',
        ),
    ),
));

CSF::createSection($prefix, array(
    'id' => 'ad_fields',
    'title' => __('广告配置', 'kratos'),
    'icon' => 'fas fa-ad',
));

CSF::createSection($prefix, array(
    'parent' => 'ad_fields',
    'title' => __('文章广告', 'kratos'),
    'icon' => 'fas fa-arrow-right',
    'fields' => array(
        array(
            'id' => 's_singletop_fieldset',
            'type' => 'fieldset',
            'fields' => array(
                array(
                    'type' => 'subheading',
                    'content' => __('文章顶部广告', 'kratos'),
                ),
                array(
                    'id' => 's_singletop',
                    'type' => 'switcher',
                    'title' => __('功能开关', 'kratos'),
                    'subtitle' => __('开启/关闭文章顶部广告', 'kratos'),
                    'text_on' => __('开启', 'kratos'),
                    'text_off' => __('关闭', 'kratos'),
                ),
                array(
                    'id' => 's_singletop_img',
                    'type' => 'upload',
                    'title' =>  __('广告图片', 'kratos'),
                    'library' => 'image',
                    'preview' => true,
                    'subtitle' => __('仅当开启此功能时生效', 'kratos'),
                ),
                array(
                    'id' => 's_singletop_url',
                    'type' => 'text',
                    'title' => __('广告链接', 'kratos'),
                    'subtitle' => __('如果不填写，将只显示图片', 'kratos'),
                ),
            ),
            'default' => array(
                's_singletop' => false,
                's_singletop_img' => get_template_directory_uri() . '/assets/img/ad.png',
            ),
        ),
        array(
            'id' => 's_singledown_fieldset',
            'type' => 'fieldset',
            'fields' => array(
                array(
                    'type' => 'subheading',
                    'content' => __('文章底部广告', 'kratos'),
                ),
                array(
                    'id' => 's_singledown',
                    'type' => 'switcher',
                    'title' => __('功能开关', 'kratos'),
                    'subtitle' => __('开启/关闭文章底部广告', 'kratos'),
                    'text_on' => __('开启', 'kratos'),
                    'text_off' => __('关闭', 'kratos'),
                ),
                array(
                    'id' => 's_singledown_img',
                    'type' => 'upload',
                    'title' =>  __('广告图片', 'kratos'),
                    'library' => 'image',
                    'preview' => true,
                    'subtitle' => __('仅当开启此功能时生效', 'kratos'),
                ),
                array(
                    'id' => 's_singledown_url',
                    'type' => 'text',
                    'title' => __('广告链接', 'kratos'),
                    'subtitle' => __('如果不填写，将只显示图片', 'kratos'),
                ),
            ),
            'default' => array(
                's_singledown' => false,
                's_singledown_img' => get_template_directory_uri() . '/assets/img/ad.png',
            ),
        ),
    ),
));

CSF::createSection($prefix, array(
    'title' => __('备份恢复', 'kratos'),
    'icon' => 'fas fa-undo',
    'fields' => array(
        array(
            'type' => 'backup',
        ),
    ),
));

CSF::createSection($prefix, array(
    'title' => __('关于主题', 'kratos'),
    'icon' => 'fas fa-question-circle',
    'fields' => array(
        array(
            'type' => 'subheading',
            'content' => __('基础信息', 'kratos'),
        ),
        array(
            'type' => 'submessage',
            'style' => 'info',
            'content' => __('提示：在反馈主题相关的问题时，请同时复制并提交下面的内容。', 'kratos'),
        ),
        array(
            'type' => 'content',
            'content' => '<ul style="margin: 0 auto;"> <li>' . __('PHP 版本：', 'kratos') . PHP_VERSION . '</li> <li>' . __('Kratos 版本：', 'kratos') . THEME_VERSION . '</li> <li>' . __('WordPress 版本：', 'kratos') . $wp_version . '</li> <li>' . __('User Agent 信息：', 'kratos') . $_SERVER['HTTP_USER_AGENT'] . '</li> </ul>',
        ),

        array(
            'type' => 'subheading',
            'content' => __('资料文档', 'kratos'),
        ),
        array(
            'type' => 'content',
            'content' => '<ul style="margin: 0 auto;"> <li>' . __('说明文档：', 'kratos') . '<a href="https://www.vtrois.com/" target="_blank">https://www.vtrois.com/</a></li> <li>' . __('问题反馈：', 'kratos') . '<a href="https://github.com/vtrois/kratos/issues" target="_blank">https://github.com/vtrois/kratos/issues</a></li> <li>' . __('常见问题：', 'kratos') . '<a href="https://github.com/vtrois/kratos/wiki/%E5%B8%B8%E8%A7%81%E9%97%AE%E9%A2%98" target="_blank">https://github.com/vtrois/kratos/wiki</a></li> <li>' . __('更新日志：', 'kratos') . '<a href="https://github.com/vtrois/kratos/releases" target="_blank">https://github.com/vtrois/kratos/releases</a></li> <li>' . __('捐赠记录：', 'kratos') . '<a href="https://docs.qq.com/sheet/DV0NwVnNoYWxGUmlD" target="_blank">https://docs.qq.com/sheet/DV0NwVnNoYWxGUmlD</a></li> </ul>',
        ),
        array(
            'type' => 'subheading',
            'content' => __('版权声明', 'kratos'),
        ),
        array(
            'type' => 'content',
            'content' => __('主题源码使用 <a href="https://github.com/vtrois/kratos/blob/main/LICENSE" target="_blank">GPL-3.0 协议</a> 进行许可，说明文档使用 <a href="https://creativecommons.org/licenses/by-nc-nd/4.0/" target="_blank">CC BY-NC-ND 4.0</a> 进行许可。', 'kratos'),
        ),
        array(
            'type' => 'subheading',
            'content' => __('讨论交流', 'kratos'),
        ),
        array(
            'type' => 'content',
            'content' => '<div style="max-width:800px;"><img style="width: 100%;height: auto;" src="' . get_template_directory_uri() . '/assets/img/options/discuss.png"></div>',
        ),
        array(
            'type' => 'subheading',
            'content' => __('打赏支持', 'kratos'),
        ),
        array(
            'type' => 'content',
            'content' => '<div style="max-width:800px;"><img style="width: 100%;height: auto;" src="' . get_template_directory_uri() . '/assets/img/options/donate.png"></div>',
        ),
    ),
));
