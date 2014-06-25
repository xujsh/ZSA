//
//  AnnounceDetailViewController.h
//  teaching
//
//  Created by kidliuxu on 14-1-24.
//  Copyright (c) 2014年 icesmart. All rights reserved.
//

#import "BaseViewController.h"

@interface AnnounceDetailViewController : BaseViewController

@property ( nonatomic , retain) NSURL *courseUrl;

- (id) initWithUrl:(NSURL *) url;

@end
