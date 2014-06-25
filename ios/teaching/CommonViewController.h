//
//  CommonViewController.h
//  teaching
//
//  Created by kidliuxu on 14-3-17.
//  Copyright (c) 2014年 icesmart. All rights reserved.
//

#import "BaseViewController.h"

@interface CommonViewController : BaseViewController

@property ( nonatomic , retain) NSURL *courseUrl;

- (id) initWithUrl:(NSURL *) url;

@end
