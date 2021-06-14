<?php

/*
 * @copyright   2014 Mautic Contributors. All rights reserved
 * @author      Mautic
 *
 * @link        http://mautic.org
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
$view->extend('MauticCoreBundle:Default:content.html.php');
$view['slots']->set('mauticContent', 'order');
$view['slots']->set('headerTitle', $view['translator']->trans('mautic.ecommerce.order') . ' ' . $item->getReference());

?>

<!-- start: box layout -->
<div class="box-layout">
    <!-- left section -->
    <div class="col-md-9 bg-white height-auto">
        <div class="bg-auto">
            <!-- asset detail collapseable -->
            <div class="collapse" id="product-details">
                <div class="pr-md pl-md pb-md">
                    <div class="panel shd-none mb-0">
                        <table class="table table-bordered table-striped mb-0">
                            <tbody>
                            <?php echo $view->render(
                                'MauticCoreBundle:Helper:details.html.php',
                                ['entity' => $item]
                            ); ?>
                            <tr>
                                <td width="20%"><span class="fw-b"><?php echo $view['translator']->trans(
                                            'mautic.ecommerce.orderId'
                                        ); ?></span></td>
                                <td><?php echo $item->getOrderId(); ?></td>
                            </tr>
                            <tr>
                                <td width="20%"><span class="fw-b"><?php echo $view['translator']->trans(
                                            'mautic.ecommerce.shopId'
                                        ); ?></span></td>
                                <td><?php echo $item->getShopId(); ?></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!--/ asset detail collapseable -->
        </div>

        <div class="bg-auto bg-dark-xs">
            <!-- asset detail collapseable toggler -->
            <div class="hr-expand nm">
                <span data-toggle="tooltip" title="Detail">
                    <a href="javascript:void(0)" class="arrow text-muted collapsed" data-toggle="collapse"
                       data-target="#product-details"><span class="caret"></span> <?php echo $view['translator']->trans(
                            'mautic.core.details'
                        ); ?></a>
                </span>
            </div>
            <!--/ asset detail collapseable toggler -->

        </div>

        <?php echo $view['content']->getCustomContent('details.stats.graph.below', $mauticTemplateVars); ?>

        <!-- start: tab-content -->
        <div class="tab-content pa-md preview-detail">
            <div class="row">
                <div class="col-md-6">
                    <h6><?php echo $view['translator']->trans('mautic.core.id'); ?></h6>
                    <p><?php echo $item->getId(); ?></p>
                </div>
                
                <div class="col-md-6">
                    <h6><?php echo $view['translator']->trans('mautic.ecommerce.externalId'); ?></h6>
                    <p><?php echo $item->getOrderId(); ?></p>
                </div>
            </div>
            <div class="row">
                <table class="table table-hover table-striped table-bordered product-list" id="productTable">
                    <thead>
                    <tr>
                        <?php
                        echo $view->render(
                            'MauticCoreBundle:Helper:tableheader.html.php',
                            [
                                'sessionVar' => 'orderline',
                                'text'       => 'mautic.ecommerce.image',
                            ]
                        );


                        echo $view->render(
                            'MauticCoreBundle:Helper:tableheader.html.php',
                            [
                                'sessionVar' => 'orderline',
                                'text'       => 'mautic.ecommerce.product',
                            ]
                        );

                        echo $view->render(
                            'MauticCoreBundle:Helper:tableheader.html.php',
                            [
                                'sessionVar' => 'orderline',
                                'text'       => 'mautic.ecommerce.quantity',
                            ]
                        );

                        echo $view->render(
                            'MauticCoreBundle:Helper:tableheader.html.php',
                            [
                                'sessionVar' => 'orderline',
                                'text'       => 'mautic.ecommerce.unitprice',
                            ]
                        );

                        echo $view->render(
                            'MauticCoreBundle:Helper:tableheader.html.php',
                            [
                                'sessionVar' => 'orderline',
                                'text'       => 'mautic.ecommerce.total',
                            ]
                        );
                        ?>
                    </tr>

                    </thead>
                    <tbody>
                    <?php $total=0; ?>
                    <?php foreach ($item->getOrderRows() as $k => $row): ?>
                        <?php //echo dump($row); ?>
                        <tr>
                            <td class="">

                                <a href="<?php echo $view['router']->path(
                                    'mautic_product_action',
                                    ['objectAction' => 'view', 'objectId' => $row->getProductId()->getId()]
                                ); ?>"
                                >
                                    <img src="<?php echo $view['assets']->getUrl('plugins/PrestashopEcommerceBundle/Assets/img/products/' . $row->getProductId()->getImageUrl()) ?>" alt="<?php echo $row->getProductId()->getName(); ?>" class="img-thumbnail" style="max-width: 100px; display: block; margin: auto"/>
                                </a>

                            </td>
                            <td class="">
                                <a href="<?php echo $view['router']->path(
                                    'mautic_product_action',
                                    ['objectAction' => 'view', 'objectId' => $row->getProductId()->getId()]
                                ); ?>"
                                >
                                    <span><?php echo $row->getProductId()->getName(); ?></span></span>
                                </a>

                            </td>
                            <td class="">
                                <span><?php echo $row->getProductQuantity(); ?></span></span>
                            </td>
                            <td class="text-right"><?php echo '$ ' .number_format($row->getProductPrice(), 2); //TODO CURRENCY ?></td>
                            <td class="text-right">
                                <?php $totalRow=((float)$row->getProductPrice() * (float)$row->getProductQuantity()); ?>
                                <?php $total= $total + $totalRow; ?>
                                <?php echo '$ ' .number_format($totalRow, 2); //TODO CURRENCY ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="3" style="visibility:hidden;"></td>
                        <td><?php echo$view['translator']->trans('mautic.ecommerce.total');?></td>
                        <td class="text-right"><?php echo '$ ' .number_format($item->getTotalProducts(), 2); //TODO CURRENCY ?></td>
                    </tr>
                    <tr>
                        <td colspan="3" style="visibility:hidden;"></td>
                        <td><?php echo$view['translator']->trans('mautic.ecommerce.shipping');?></td>
                        <td class="text-right"><?php echo '$ ' .number_format($item->getTotalShipping(), 2); //TODO CURRENCY ?></td>
                    </tr>
                    <tr>
                        <td colspan="3" style="visibility:hidden;"></td>
                        <td><?php echo$view['translator']->trans('mautic.ecommerce.totalPaid');?></td>
                        <td class="text-right"><?php echo '$ ' .number_format($item->getTotalPaid(), 2); //TODO CURRENCY ?></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!--/ end: tab-content -->

    </div>
    <!--/ left section -->

    <!-- right section -->
    <div class="col-md-3 bg-white bdr-l height-auto">
        <!-- activity feed -->
        <?php echo $view->render('MauticCoreBundle:Helper:recentactivity.html.php', ['logs' => $logs]); ?>
    </div>
    <!--/ right section -->
    <input name="entityId" id="entityId" type="hidden" value="<?php echo $view->escape($item->getId()); ?>"/>
</div>
<!--/ end: box layout -->
