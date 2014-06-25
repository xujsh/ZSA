//
//  CourseLogListViewController.h
//  teaching
//
//  Created by kidliuxu on 14-1-24.
//  Copyright (c) 2014年 icesmart. All rights reserved.
//

#import "BaseViewController.h"
#import "CourseLogsDetailViewController.h"

@interface CourseLogListViewController : BaseViewController

@property ( nonatomic , retain) NSURL *courseUrl;

- (id) initWithUrl:(NSURL *) url;

@end
