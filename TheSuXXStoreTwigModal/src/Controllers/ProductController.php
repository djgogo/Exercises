<?php

class SuxxProductController implements SuxxController
{
    /**
     * @var SuxxCommentTableDataGateway
     */
    private $commentDataGateway;

    /**
     * @var SuxxProductTableDataGateway
     */
    private $productDataGateway;

    public function __construct(SuxxProductTableDataGateway $productDataGateway, SuxxCommentTableDataGateway $commentDataGateway)
    {
        $this->commentDataGateway = $commentDataGateway;
        $this->productDataGateway = $productDataGateway;
    }

    public function execute(SuxxRequest $request, SuxxSession $session, SuxxResponse $response)
    {
        if ($request->getValue('pid') === '') {
            return '404errorview.twig';
        }
        $response->product = $this->productDataGateway->findProductById($request->getValue('pid'));
        $response->comments = $this->commentDataGateway->findCommentsByPid($request->getValue('pid'));

        return 'product.twig';
    }

}
